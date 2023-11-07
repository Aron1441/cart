<?php

namespace controller;
use Model\Catalog\Catalog;

class CatalogController extends BaseController
{
    const TABLE_NAME = "category";
    //TODO: временное рещение, пока что существует только
    // один каталог
    const DEFAULT_CATEGORY_ID = 3;
    static function get($arg = null) {
        Db->getRow(self::TABLE_NAME, 'catalog_id', self::DEFAULT_CATEGORY_ID);
        $objects = [];
        Db->intoClassObjs("Model\Catalog\Catalog", $objects);

        echo json_encode($objects);
    }
    static function getByCatId($fieldName) {}
    public static function add($name)
    {
        echo "add";
    }
}