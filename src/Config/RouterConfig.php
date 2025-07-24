<?php

namespace Sandersao\FileTransfer\Config;

use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\Controller\NavController;
use Sandersao\FileTransfer\Controller\PathController;

class RouterConfig {
    private NavController $nav;
    private PathController $path;
    public function __construct(
        NavController $nav,
        PathController $path
    ) {
        $this->nav = $nav;
        $this->path = $path;
    }

    public function route(RouteCollector $collection) {
        $this->path($collection);
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

    public function path(RouteCollector $collection){
        $collection->get('/path', function () {
            return $this->path->listView($_GET['path'] ?? null);
        });
    }

    public function nav(RouteCollector $collection){
        $collection->get('/navigate', function () {
            return $this->nav->navigate($_GET['path'] ?? null);
        });
    }
}
