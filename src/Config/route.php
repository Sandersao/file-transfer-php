<?php

/** @var DI\Container $container */

use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\Controller\FileController;
use Sandersao\FileTransfer\Controller\NavController;
use Sandersao\FileTransfer\System\ResponseSystem;

/** @var RouteCollector $collection */
/** @var ResponseSystem $responseSystem */
$collection->get('', function() use ($responseSystem) {
    $responseSystem->redirect('/navigate');
});

$collection->get('/hello-world', function ()  use ($responseSystem) {
    $responseSystem->show([
        'message' => 'Hello world',
        'ip' => $_SERVER['SERVER_ADDR'] ?? 'Impossível pegar o endereço'
    ]);
});

$collection->get('/php-info', function () {
    phpinfo();
});

/** @var NavController $navigateController */
$navigateController = $container->get(NavController::class);
$collection->get('/navigate', function () use ($navigateController) {
    return $navigateController->navigate($_GET['path'] ?? null);
});

/** @var FileController $navigateController */
$fileController = $container->get(FileController::class);
$collection->get('/file/preview', function () use ($fileController) {
    return $fileController->preview($_GET['path'] ?? null);
});

$collection->get('/file/download', function () use ($fileController) {
    return $fileController->download($_GET['path'] ?? null);
});
