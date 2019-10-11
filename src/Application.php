<?php

namespace Wladweb\SimpleCMS;

use Wladweb\SimpleCMS\BlogException;
use Wladweb\SimpleCMS\Assets\SimpleInstall;
use Wladweb\SimpleCMS\Assets\Connection;
use RedBeanPHP\RedException;

class Application
{
    const CONTROLLERS_PREFIX = 'Wladweb\\SimpleCMS\\Controller\\';
    const CONTROLLER = 'Controller';
    const ACTION = 'Action';
    
    public const DEBUG = true;
    
    public static $app_dir;
    
    private static $controller;
    private static $action;
    private static $params = array();

    /**
     * Parsing route from request uri
     * 
     * @return void 
     */
    public static function run()
    {
        self::$app_dir = \realpath('.');
        Connection::connect();
        SimpleInstall::checkInstallation();

        
        
        $url_arr = array();
        $url = trim($_SERVER['REQUEST_URI'], '/');

        if (!empty($url)) {
            $url_arr = explode('/', $url);
        }

        $ccount = count($url_arr);

        switch ($ccount) {
            case 0:
                self::$controller = 'Index' . self::CONTROLLER;
                self::$action = 'index' . self::ACTION;
                break;
            case 1:
                self::$controller = ucfirst($url_arr[0]) . self::CONTROLLER;
                self::$action = 'index' . self::ACTION;
                break;
            case 2:
                self::$controller = ucfirst($url_arr[0]) . self::CONTROLLER;
                self::$action = $url_arr[1] . self::ACTION;
                break;
            default:
                self::$controller = ucfirst($url_arr[0]) . self::CONTROLLER;
                self::$action = $url_arr[1] . self::ACTION;
                self::parseParametrs(array_slice($url_arr, 2));
        }

        self::route();
    }

    /**
     * Start route, cath Exceptions
     * 
     * @return void 
     */
    public static function route()
    {
        try {
            self::startRoute();
        } catch (BlogException $e_blog) {
            echo $e_blog->getMessage();
        } catch (RedException $e_red) {
            echo $e_red->getMessage();
        }
    }

    /**
     * Create Controllers and start actions with ReflectionClass
     * 
     * @throws BlogException Action not found
     * @throws BlogException Controller not found
     * @throws BlogException Controllers file not found
     * @return void 
     */
    private static function startRoute()
    {
        if (file_exists('src/Controller/' . self::getController() . '.php')) {

            if (class_exists(self::CONTROLLERS_PREFIX . self::getController())) {

                $rfc = new \ReflectionClass(self::CONTROLLERS_PREFIX . self::getController());

                if ($rfc->hasMethod(self::getAction())) {

                    $method = $rfc->getMethod(self::getAction());
                    $controller = $rfc->newInstance();
                    $method->invoke($controller);
                } else {
                    throw new BlogException('Произошла ошибка маршрутизации. Метод.');
                }
            } else {
                throw new BlogException('Произошла ошибка маршрутизации.Класс.');
            }
        } else {
            throw new BlogException('Произошла ошибка маршрутизации.Файл.');
        }
    }

    /**
     * Create and save query paprameters array $key => $value
     * 
     * @param array $params Array with params from request uri
     */
    private static function parseParametrs(array $params)
    {
        $cnt = count($params);

        if ($cnt % 2 !== 0) {
            array_pop($params);
            --$cnt;
        }

        $i = 0;
        $keys = $values = array();

        while ($i < $cnt) {
            $keys[] = $params[$i];
            $values[] = $params[$i + 1];
            $i += 2;
        }

        if (!empty($keys)) {
            self::$params = array_combine($keys, $values);
        }
    }

    /**
     * Return controller class name
     * 
     * @return string controller class name
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * Return action method name
     * 
     * @return string action method name
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * Return query parameters
     * 
     * @return array parameters
     */
    public static function getParams()
    {
        return self::$params;
    }
}
