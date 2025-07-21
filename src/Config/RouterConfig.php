<?php

namespace Sandersao\FileTransfer\Config;

use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\Controller\FileController;

class RouterConfig {
    private FileController $file;
    public function __construct(FileController $file) {
        $this->file = $file;
    }

    public function route(RouteCollector $collection) {
        $this->file($collection);
        $collection->get('/hello-world', function () {
            return [
                'message' => 'Hello world',
                'ip' => $_SERVER['SERVER_ADDR'] ?? 'Impossível pegar o endereço'
            ];
        });
    }

    public function file(RouteCollector $collection){
        $collection->get('/file', function () {
            return $this->file->list();
        });
    }
}
