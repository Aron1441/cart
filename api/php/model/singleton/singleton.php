<?php

namespace model\singleton;
class Singleton
{
    static array $instance = [];

    static function getInstance(): static {
        if($key = array_search(new static(), self::$instance)) return self::$instance[$key];
        $instance = new static();
        array_push(self::$instance, $instance);

        return $instance;
    }
}