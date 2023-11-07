<?php

namespace model;

use model\singleton\Singleton;

class Redis extends Singleton
{
    private \Redis $rInstance;

    public function __construct()
    {
        $this->rInstance = new \Redis();
        $this->connect();
    }

    function connect(): void {
        $this->rInstance->connect(
            'redis',
            6379
        );
        $this->rInstance->auth($_ENV['REDIS_PASSWORD']);
    }

    function hSetArray($name, $array) {
        foreach ($array as $key => $value) {
            $this->rInstance->hSet('auth', $key, $value);
        }
    }

    function userExists($name) {
        //TODO: обновление данных, к примеру было пользователь
        // с login "any" и потом его удалили, но в оперативке всё
        // ещё есть "any"
        return in_array('test1', $this->rInstance->hGetAll('auth'));
    }
}