<?php

namespace db;
use model\singleton\Singleton;
use mysqli;
use mysqli_result;

class Db extends Singleton
{
    public mysqli_result $queryResult;
    private static mysqli $connection;
    const DECORATED_FUNC = ['query', 'preparedQuery'];

    public function __construct()
    {
        self::$connection = Db::connect();
    }

    private static function connect(): mysqli {
        $result = new mysqli('mysql', 'artem', 'cxfcnmt1441', 'cart');
        if ($result->connect_error) {
            die('Connect Error (' . $result->connect_errno . ') ' . $result->connect_error);
        }

        return $result;
    }

    function fetchColumns(string $query, string $colName) {
        return $this->fetchColumnsDecorator([$this, self::DECORATED_FUNC[0]])($query, $colName);
    }

    function fetchColumnsDecorator(callable $func): callable {
        return function (string $query, $colName) use ($func) {
            $result = $func($query);

           $finfo = $result->fetch_all(MYSQLI_ASSOC);

           return array_column($finfo, $colName);
        };
    }

    public function query($queryString): mysqli_result
    {
        $this->queryResult = self::$connection->query($queryString);

        return $this->queryResult;
    }

    public function valuesToBindTypes($array): string {
        $resultString = "";
        foreach ($array as $key => $val) {
            $types = is_numeric($val) ? is_float($val) ? 'd': 'i'
                : 's';
            $resultString.= $types;
        }

        return $resultString;
    }

    public function insertPrepared($arrAssoc, $tableName): bool {
        $markers = substr(str_repeat('?,', count($arrAssoc)), 0, -1);
        $collNames = join(',', array_keys($arrAssoc));
        $wildcards = array_values($arrAssoc);

        try {
            $stmt = self::$connection->prepare("INSERT INTO " . $tableName . "($collNames) VALUES ($markers)");
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            die;
        }

        $stmt->bind_param($this->valuesToBindTypes($wildcards), ...$wildcards);

        return $stmt->execute();
    }

    public function preparedQuery($query, $args): mysqli_result {
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param('s', $args);
        $stmt->execute();
        $this->queryResult = $stmt->get_result();

        return $this->queryResult;
    }

    public function getResult($table): self {
        $stmt = self::$connection->prepare("SELECT * FROM $table");
        $stmt->execute();
        $this->queryResult = $stmt->get_result();

        return $this;
    }

    public function intoClassObjs($className, array &$array): void {
        while ($obj = $this->queryResult->fetch_object($className)) {
            array_push($array, $obj);
        }
    }
    public function getRow(string $table, string $field, mixed $filter): self {
        $stmt = self::$connection->prepare("SELECT * FROM $table WHERE $field=?");

        $stmt->bind_param('s', $filter);
        $stmt->execute();
        $this->queryResult = $stmt->get_result();

        return $this;
    }
    public function getColumn(string $name)
    {
        return $this->queryResult->fetch_object()->$name;
    }
}