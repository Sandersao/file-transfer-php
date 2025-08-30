<?php

namespace Sandersao\FileTransfer\System;

use Exception;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

class DispatchSystem
{
    public function dispatch(RouteCollector $routeCollection){
        $dispatcher = new Dispatcher($routeCollection->getData());
        try {
            $responseSystem = $dispatcher->dispatch(
                $_SERVER['REQUEST_METHOD'],
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );

            if(gettype($responseSystem) === 'string'){
                echo $responseSystem;
            }

            if (gettype($responseSystem) === 'array') {
                echo json_encode($responseSystem, JSON_PRETTY_PRINT);
            }
        } catch (Exception $e) {
            http_response_code(404);
            echo 'Página não encontrada.';
            echo $e->getMessage();
        }
    }
}
