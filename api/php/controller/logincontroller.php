<?php

namespace controller;

class logincontroller
{
    static function getUIID() {
        if(!isset($_COOKIE['TestCookie'])) {
            $tmp = uniqid();
            setcookie("TestCookie", $tmp);
            return $tmp;
        }

        return $_COOKIE['TestCookie'];
    }

    static function get($arg = null) {
        $uid = logincontroller::getUIID();
        $location = 'https://oauth.vk.com/authorize';
        $data = array('client_id'=> '51831859',
            'display' => 'page',
            'redirect_uri'=>'http://127.0.0.1:5173/login',
            'response_type' => 'code',
            'v' => 5.131
            );

        $res = $location . '?' . http_build_query($data);
        header("Location: $res");
        exit;
    }
}