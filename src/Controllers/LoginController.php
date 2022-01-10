<?php

namespace Laravolt\OnlyOffice\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Laravolt\OnlyOffice\Models\OnlyOfficeTokens;

class LoginController extends Controller
{
    public function store()
    {
        $email = request()->email;
        $password = request()->password;

        $res = $this->fetchLogin($email, $password);

        if ($res->successful()) {
            $resJson = json_decode($res->body())->response;

            // TODO SAVE TOKEN AND EXPIRED TOKEN TO DB
            $onlyOfficeTokens = new OnlyOfficeTokens();
            $onlyOfficeTokens->user_id = auth()->id();
            $onlyOfficeTokens->token = $resJson->token;
            $onlyOfficeTokens->expired_at = $resJson->expires;
            $onlyOfficeTokens->save();

            return redirect()->back()->withSuccess('Successfully connect to onlyoffice');
        } else {
            return redirect()->back()->withErrors('Email or password in correct');
        }
    }

    private function fetchLogin($email, $password)
    {
        $res = Http::post(config()->get('services.onlyoffice.groupoffice_url')."/api/2.0/authentication", [
            "username" => $email,
            "password" => $password,
        ]);

        return $res;
    }
}
