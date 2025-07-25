<?php

namespace Sandersao\FileTransfer\Config;

use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\Controller\FileController;
use Sandersao\FileTransfer\Controller\NavController;

class RouterConfig {
    private FileController $file;
    private NavController $nav;
    public function __construct(
        FileController $file,
        NavController $nav
    ) {
        $this->file = $file;
        $this->nav = $nav;
    }

    public function route(RouteCollector $collection) {
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
        $collection->get('/navigate', function () {
            return $this->nav->navigate($_GET['path'] ?? null);
        });
        $collection->get('/file/preview', function () {
            return $this->file->preview($_GET['path'] ?? null);
        });
        $collection->get('/file/download', function () {
            return $this->file->download($_GET['path'] ?? null);
        });
    }
}
