<?php

namespace controller\auth;

use controller\BaseController;

class AuthController extends BaseController
{
    public static function get($arg = null)
    {
        var_dump($arg);
        self::encrypt($arg['password']);
        $arg['login'];
        $arg['password'];
        $fingerPrint = "";
        $header = ['alg' => "HS256", 'typ' => "JWT"];
        $payload = ['userId' => 'user_id'];
        json_encode($header);

//        setcookie("TestCookie", $tmp, 3600000);
    }


}