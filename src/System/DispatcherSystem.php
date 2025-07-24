<?php

namespace Sandersao\FileTransfer\System;

use Exception;
use Phroute\Phroute\Dispatcher as PhrouteDispatcher;
use Phroute\Phroute\RouteCollector;

class DispatcherSystem
{
    private ViewSystem $view;
    public function __construct(ViewSystem $view)
    {
        $this->view = $view;
    }

    public function dispatch(RouteCollector $routeCollection){
        $phrouteDispatcher = new PhrouteDispatcher($routeCollection->getData());
        try {
            $responseSystem = $phrouteDispatcher->dispatch(
                $_SERVER['REQUEST_METHOD'],
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );

            $responseSystem->provide();
        } catch (Exception $e) {
            http_response_code(404);
            echo 'Página não encontrada.';
            echo $e->getMessage();
        }
    }
}
