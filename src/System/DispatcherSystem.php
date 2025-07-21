<?php

namespace Sandersao\FileTransfer\System;

use Exception;
use Phroute\Phroute\Dispatcher as PhrouteDispatcher;
use Phroute\Phroute\RouteCollector;

class DispatcherSystem
{
    public function dispatch(RouteCollector $routeCollection){
        $phrouteDispatcher = new PhrouteDispatcher($routeCollection->getData());
        try {
            $response = $phrouteDispatcher->dispatch(
                $_SERVER['REQUEST_METHOD'],
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );

            if (is_array($response)) {
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                echo $response;
            }
        } catch (Exception $e) {
            http_response_code(404);
            echo 'Página não encontrada.';
            echo $e->getMessage();
        }
    }
}
