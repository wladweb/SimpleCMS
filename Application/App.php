<?php

namespace SimpleCMS\Application;

use SimpleCMS\Application\BlogException;
use RedBeanPHP\RedException;

class App {

    const CONTROLLERS_PREFIX = 'SimpleCMS\\Application\\Controller\\';
    const CONTROLLER = 'Controller';
    const ACTION = 'Action';

    private static $instance;
    private $controller;
    private $action;
    private $params = array();
    
    /**
     * Start parse route
     */
    private function __construct() {
        $this->parseRoute();
    }
    
    /**
     * Return instance of Application. Pattern Singleton.
     * 
     * @return App
     */
    public static function getInstance() {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
            return self::$instance;
        } else {
            return self::$instance;
        }
    }
    
    /**
     * Parsing route from request uri
     * 
     * @return void 
     */
    private function parseRoute() {

        $this->is_first_start();

        $url_arr = array();
        $url = trim($_SERVER['REQUEST_URI'], '/');

        if (!empty($url)) {
            $url_arr = explode('/', $url);
        }

        $ccount = count($url_arr);

        switch ($ccount) {
            case 0:
                $this->controller = 'Index' . self::CONTROLLER;
                $this->action = 'index' . self::ACTION;
                break;
            case 1:
                $this->controller = ucfirst($url_arr[0]) . self::CONTROLLER;
                $this->action = 'index' . self::ACTION;
                break;
            case 2:
                $this->controller = ucfirst($url_arr[0]) . self::CONTROLLER;
                $this->action = $url_arr[1] . self::ACTION;
                break;
            default:
                $this->controller = ucfirst($url_arr[0]) . self::CONTROLLER;
                $this->action = $url_arr[1] . self::ACTION;
                $this->parseParametrs(array_slice($url_arr, 2));
        }
    }
    
    /**
     * Start route, cath Exceptions
     * 
     * @return void 
     */
    public function route() {
        try {
            $this->startRoute();
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
    private function startRoute() {
        if (file_exists('Application/Controller/' . $this->getController() . '.php')) {

            if (class_exists(self::CONTROLLERS_PREFIX . $this->getController())) {

                $rfc = new \ReflectionClass(self::CONTROLLERS_PREFIX . $this->getController());

                if ($rfc->hasMethod($this->getAction())) {

                    $method = $rfc->getMethod($this->getAction());
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
    private function parseParametrs(array $params) {
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
            $this->params = array_combine($keys, $values);
        }
    }
    
    /**
     * Return controller class name
     * 
     * @return string controller class name
     */
    private function getController() {
        return $this->controller;
    }
    
    /**
     * Return action method name
     * 
     * @return string action method name
     */
    private function getAction() {
        return $this->action;
    }
    
    /**
     * Return query parameters
     * 
     * @return array parameters
     */
    public function getParams() {
        return $this->params;
    }
    
    /**
     * Check application first start 
     * 
     * @return void 
     */
    private function is_first_start() {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/setup.ini';
        session_start();
        if (!is_file($path)) {
            include 'Application/View/atemplate/please_rename_config_file.php';
            exit;
        } elseif (isset($_SESSION['first_start']) || isset($_COOKIE['bad_close_session'])) {
            include 'Application/View/atemplate/please_input_data.php';
            exit;
        }

        $this->sess_destroy();
    }
    
    /**
     * Destroing session
     * 
     * @return void 
     */
    private function sess_destroy() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

}
