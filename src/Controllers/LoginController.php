<?php

namespace Laravolt\OnlyOffice\Controllers;

use Illuminate\Routing\Controller;
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
            $cookie = Cookie::make('isLogin', json_decode($res->body())->response->token, 60*24*365);

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
