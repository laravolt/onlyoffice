<?php

namespace Laravolt\OnlyOffice\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller
{
    public function store()
    {
        $email = request()->email;
        $password = request()->password;

        $res = $this->fetchLogin($email, $password);

        if ($res->successful()) {
            $carbon = new Carbon(json_decode($res->body())->response->expires);
            $cookie = Cookie::make('isLogin', json_decode($res->body())->response->token, $carbon->diffInRealMinutes(Carbon::now()));

            return redirect()->back()->withCookie($cookie);
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
