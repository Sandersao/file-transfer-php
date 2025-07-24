<?php

namespace Sandersao\FileTransfer\Config;

use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\Controller\NavController;

class RouterConfig {
    private NavController $nav;
    public function __construct(
        NavController $nav
    ) {
        $this->nav = $nav;
    }

    public function route(RouteCollector $collection) {
        $this->nav($collection);
        $collection->get('', function() {
            $link = '/navigate';
            echo "<script>window.location.href = '$link';</script>";
            die();
        });
        $collection->get('/hello-world', function () {
            return [
                'message' => 'Hello world',
                'ip' => $_SERVER['SERVER_ADDR'] ?? 'Impossível pegar o endereço'
            ];
        });
    }

    public function nav(RouteCollector $collection){
        $collection->get('/navigate', function () {
            return $this->nav->navigate($_GET['path'] ?? null);
        });
    }
}
