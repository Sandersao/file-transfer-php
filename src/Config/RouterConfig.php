<?php

namespace Sandersao\FileTransfer\Config;

use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\Controller\PathController;

class RouterConfig {
    private PathController $path;
    public function __construct(PathController $path) {
        $this->path = $path;
    }

    public function route(RouteCollector $collection) {
        $this->path($collection);
        $collection->get('', function() {
            $link = '/path';
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
}
