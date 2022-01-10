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

            // Search if auth with token is alreayd exists.
            $onlyOfficeToken = OnlyOfficeTokens::where('user_id', auth()->id())->first();

            if($onlyOfficeToken) {
                // Update token
                $onlyOfficeToken->token = $resJson->token;
                $onlyOfficeToken->expired_at = $resJson->expires;
                $onlyOfficeToken->save();
            } else {
                // TODO SAVE TOKEN AND EXPIRED TOKEN TO DB
                $newOnlyOfficeToken = new OnlyOfficeTokens();
                $newOnlyOfficeToken->user_id = auth()->id();
                $newOnlyOfficeToken->token = $resJson->token;
                $newOnlyOfficeToken->expired_at = $resJson->expires;
                $newOnlyOfficeToken->save();
            }

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
