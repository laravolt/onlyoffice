<?php

namespace Laravolt\Onlyoffice\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class OnlyOfficeController extends Controller
{
    public function onlyofficeLogin()
    {

        $email = request()->email;
        $password = request()->password;

        $res = $this->loginOnlyoffice($email, $password);

        if($res->successful()) {
            $cookie = Cookie::make('isLogin', json_decode($res->body())->response->token, 60);
            return redirect()->back()->withCookie($cookie);
        } else {
            return redirect()->back()->withError('Email / Password in correct');
        }
    }

    public function loginOnlyoffice($email, $password)
    {
        $res = Http::post(config()->get('services.onlyoffice.groupoffice_url')."/api/2.0/authentication", [
            "username" => $email,
            "password" => $password
        ]);

        return $res;
    }
}
