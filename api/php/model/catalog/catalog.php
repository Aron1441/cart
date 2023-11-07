<?php
namespace Model\Catalog;

use Model\Categories\Category;

class Catalog
{
    public string $name;
    public int $id;
    public function __construct()
    {
    }

    public function getId(): int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function addCategory($name): void
    {
        array_push(self::$categories, new Category($name));
    }
}