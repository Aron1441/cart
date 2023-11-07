<?php

namespace App;
use db\Db;
use di\Container;
use controller\AuthController;
use model\Redis;
use php\Controller\CatalogController;

define('SITE_DIREC', __DIR__ . '/php');
error_reporting(E_ALL);

require_once('./php/model/loader/autoload.php');

AutoLoad::register();
$db = Db::getInstance();
$container = new Container();
define('Db', $db);
define('Di', $container);
header('Access-Control-Allow-Origin: *');

$router = $container->get('Router\Router');

$redis = new Redis();
$redis->connect();
$logins = Db->fetchColumns("SELECT * FROM users", 'login');

$redis->hSetArray('logins', $logins);
$redis->userExists('test1');