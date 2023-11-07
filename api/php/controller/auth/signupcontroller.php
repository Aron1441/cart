<?php

namespace controller\auth;

use controller\BaseController;
use model\User;

class SignupController extends BaseController
{
    static function get($arg = null) {

    }

    static function add(array $arrAssoc): void {
        $user = Di->get('model\User', $arrAssoc);
        $user->dbInsertUser();
    }
}