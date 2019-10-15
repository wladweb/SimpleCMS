<?php

namespace Wladweb\SimpleCMS\Assets;

use Wladweb\SimpleCMS\Application as App;

/**
 * Description of Router
 *
 * @author wladweb
 */
class Router
{
    private const PREFIX = 'controller_';
    private const ACTION_PREFIX = 'Action';

    private $uri;
    private $params = [];

    public function __construct(string $uri)
    {
        $this->uri = trim($uri, "/");
    }

    /**
     * Build callable value by route
     * @return callable
     * @throws RouteNotFound if that action method doesn't exists
     */
    public function route(): callable
    {
        if (!empty($this->uri)) {

            $parts = explode('/', $this->uri);

            $controller_name = array_shift($parts);

            if (is_null($action_name = array_shift($parts))) {
                $action_name = 'index';
            } else {
                $this->params = $this->handleParams($parts);
            }
            
            App::setParams($this->params);
            
        } else {
            $controller_name = 'index';
            $action_name = 'index';
        }

        $controller = App::get(self::PREFIX . $controller_name);
        $action = $action_name . self::ACTION_PREFIX;
        
        if (!method_exists($controller, $action)){
            throw new RouteNotFound();
        }
        
        return [$controller, $action];
    }

    private function handleParams(array $params): array
    {
        if (empty($params)) {
            return [];
        }

        $params = $this->makeEven($params);

        $result = [];

        for ($i = 0, $len = count($params); $i < $len; $i++) {
            $result[$params[$i]] = $params[++$i];
        }

        return $result;
    }

    private function makeEven(array $params): array
    {
        if (count($params) % 2 !== 0) {
            array_pop($params);
        }

        return $params;
    }
}
