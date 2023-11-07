<?php

namespace Router;
use Error;
class Request
{
    public string $method;
    public int|array $args;
    public function __construct()
    {
    }

    function postParams() {
        $queries = [];
        $res = parse_str($_SERVER['QUERY_STRING'], $queries);

        return $queries;
    }
    function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    function getClassName(): string {
        preg_match("/^(?=\/)\/([A-Za-z]+)/", $_SERVER['REQUEST_URI'], $className);

        return $className[1];
    }
    //catalog/1
    function extractMethod(): bool {

        preg_match_all('/\d+/', $_SERVER['REQUEST_URI'], $numbers);

        if($this->isGet()) {
            $this->method = preg_match("/(?=\/.+\/\d?\/?)\/.+\/\d?\/?([A-Za-z]+)/", $_SERVER['REQUEST_URI'], $res)
                ? $res[1] : 'get';
            $this->args = end($numbers[0]);
        } else {
            $this->method = preg_match("/(?=\/.+\/\d?\/?)\/.+\/\d?\/?([A-Za-z]+)/", $_SERVER['REQUEST_URI'], $res)
                ? $res[1] : 'add';
            $this->args = $this->postParams();
        }

        return boolval($this->method);
    }
}