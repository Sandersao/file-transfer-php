<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use DI\Container;
use Sandersao\FileTransfer\System\BootstrapSystem;

$container = new Container();

/** @var BootstrapSystem $bootstrap */
$bootstrap = $container->get(BootstrapSystem::class);

$bootstrap->start();
