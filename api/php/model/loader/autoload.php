<?php

namespace App;
require_once(SITE_DIREC . '/utils/index.php');
use function Utils\slashReplacer;

class AutoLoad
{
    const CONTROLLER_PATH = 'controller';
    public static $scriptPath = '';

    static function getScriptPath($className): void {
        self::$scriptPath = strtolower(slashReplacer($className)) . '.php';
    }

    static function register(): void {
        $loader = function ($class): void {
            static::getScriptPath($class);
//            var_dump(SITE_DIREC . '/' . self::$scriptPath);

            include_once SITE_DIREC . '/' . self::$scriptPath;
        };

        spl_autoload_register($loader);
    }
}