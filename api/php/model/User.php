<?php

namespace model;

use function Utils\encrypt;
use model\Redis;
class User
{
    private string $uuid;
    private string $login;
    private string $password;
    private Redis $cache;
    public function __construct(Redis $cache, array $arrAssoc)
    {
        $this->uuid = uniqid();
        $this->cache = $cache;
        $this->initFields($arrAssoc);
    }

    function initFields($arrAssoc): void {
        if(!isset($arrAssoc['login']) && !isset($arrAssoc['password'])) {
           throw new \Error("Validation fields error");
        }

        list('login' => $this->login, 'password' => $this->password) = $arrAssoc;
    }

    function dbInsertUser(): bool {
        if($this->cache->userExists($this->login)) {
            return false;
        }

        return Db->insertPrepared([
            'id' => $this->uuid,
            'password' => encrypt($this->password),
            'login' => $this->login
        ], "users");
    }
}