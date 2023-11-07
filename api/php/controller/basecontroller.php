<?php

namespace controller;

abstract class BaseController
{
    const TABLE_NAME = "";

    static function get($arg = null) {
        Db->getResult(static::TABLE_NAME);
    }

    static function add(array $arrAssoc) {
        Db->insertPrepared($arrAssoc, static::TABLE_NAME);
    }
}