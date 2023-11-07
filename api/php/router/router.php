<?php

namespace Router;
use Controller\MainController;
use model\singleton\Singleton;
use \Router\Request;
use function Utils\slashReplacerB;
class Router extends Singleton
{
    public Request $request;

    //1) class // 2) если число, значит это номер экземпляра // 3) метод
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->route();
    }

    // /about /catalog/5/product/2 - детальная продукта
    // /catalog/add - добавление категории
    // /catalog/5/add - добавление продукта в категорию
    function route(): void {
        if($_SERVER['REQUEST_URI'] == '/') {
            MainController::get('');
            return;
        }

        $className = $this->request->getClassName();
        $this->request->extractMethod();

        $this->handleRequest($className);
    }

    function handleRequest($className): void {
        $controllerPath = SITE_DIREC . '/controller';
        $pathWatcher = $this->watchThough($className . 'controller.php');
        $pathWatcher($controllerPath);
    }
    function stripToControllerPath($fullPath): string {
        $relPath = strpbrk($fullPath, 'c');

        return str_replace('.php',"", $relPath);
    }

    function watchThough($needle): callable {
        $finder = function ($dir) use ($needle, &$finder) {
            $handle = opendir($dir);

            while ($fileName = ($entry = readdir($handle)) !== false)  {
                if($entry == '.' || $entry == '..') continue;

                $fullPath = $dir . "/" . $entry;

                 if(is_dir($fullPath)) {
                    $directory = $fullPath;
                    $finder($directory);
                }

                if($needle == $entry) {
                    $controllerConstructor = slashReplacerB($this->stripToControllerPath($fullPath));
//                    echo $this->request->method;

                    if(method_exists($controllerConstructor, $this->request->method)) {
                        $class = new $controllerConstructor();
                        $funcName = $this->request->method;
                        $class->$funcName($this->request->args);
                    }

                    return true;
                };
            }

            closedir($handle);
        };

        return function ($dir) use ($needle, $finder) {
            $finder($dir);
        };
    }
}