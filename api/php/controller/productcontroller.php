<?php

namespace controller;

class ProductController extends BaseController
{
    const TABLE_NAME = "products";

    static function get($arg = null) {
        Db->getRow(self::TABLE_NAME, 'category_id', $arg);

        $objects = [];
        Db->intoClassObjs("Model\Products\Product", $objects);

        echo json_encode($objects);
    }
}