<?php

namespace Wladweb\SimpleCMS;

use Wladweb\ServiceLocator\Container;
use Wladweb\ServiceLocator\Exceptions\NotFoundException;
use Wladweb\SimpleCMS\Exceptions\RouteNotFound;
use Wladweb\SimpleCMS\Assets\SimpleInstall;
use Wladweb\SimpleCMS\Assets\Connection;

class Application
{
    private const CONFIG = 'config.php';
    public const DEBUG = true;

    public static $app_dir;
    public static $container;
    private static $controller_action;
    private static $params = [];

    public static function run()
    {
        self::$app_dir = \realpath('.');
        Connection::connect();
        self::$container = Container::getContainer(self::$app_dir . DIRECTORY_SEPARATOR . self::CONFIG);
        SimpleInstall::checkInstallation();

        self::route();
        self::executeAction();
    }
    
    private static function executeAction()
    {
        call_user_func(self::$controller_action);
    }

    public static function get($index, array $redefine = [])
    {
        try {
            return self::$container->get($index, $redefine);
        } catch (NotFoundException $e) {
            exit('Service not found. 404 error');
        }
    }

    public static function setParams(array $params)
    {
        self::$params = $params;
    }

    public static function route()
    {
        $router = self::get('router', [
                    'constructor' => [
                        \filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING)
                    ]
        ]);

        try {
            self::$controller_action = $router->route();
        } catch (RouteNotFound $e) {
            echo '404'; // need to include 404 template through View
        }
    }

    public static function getController()
    {
        $parts = explode('\\', get_class(self::$controller_action[0]));
        return end($parts);
    }
    
    public static function getAction()
    {
        return self::$controller_action[1];
    }

    public static function getParams(): array
    {
        return self::$params;
    }

}
