<?php
class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {

            //echo 'UriPattern:{' . $uriPattern . '}';
            //echo 'Uri:{' . $uri . '}';
            if (preg_match("~^$uriPattern$~", $uri)) {

                $internalRoute = preg_replace("~^$uriPattern$~", $path, $uri);

                $segments = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = ucfirst(array_shift($segments)) . '_action';

                $parameters = $segments;

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerObject = new $controllerName;
                $actionStart = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($actionStart != null) {
                    break;
                }
            }
        }
    }
}