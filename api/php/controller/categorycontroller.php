<?php

namespace controller;

class CategoryController extends BaseController
{
    const TABLE_NAME = "products";

    static function get($arg = null) {
        parent::get();

        $array = Db->preparedQuery('SELECT * FROM products WHERE category_id=?', $arg)->fetch_array(MYSQLI_ASSOC);

        echo json_encode($array);
    }

    static function add(array $arrAssoc): void {
        parent::add($arrAssoc);

        http_response_code(201);
    }
}