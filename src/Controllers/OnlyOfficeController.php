<?php

namespace Laravolt\OnlyOffice\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class OnlyOfficeController extends Controller
{
    public function onlyOfficeLogin()
    {

        $email = request()->email;
        $password = request()->password;

        $res = $this->loginOnlyOffice($email, $password);

        if($res->successful()) {
            $cookie = Cookie::make('isLogin', json_decode($res->body())->response->token, 60);
            return redirect()->back()->withCookie($cookie);
        } else {
            return redirect()->back()->withErrors('Email or password in correct');
        }
    }

    public function loginOnlyOffice($email, $password)
    {
        $res = Http::post(config()->get('services.onlyoffice.groupoffice_url')."/api/2.0/authentication", [
            "username" => $email,
            "password" => $password
        ]);

        return $res;
    }
}
