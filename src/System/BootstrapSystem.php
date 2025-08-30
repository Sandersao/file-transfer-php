<?php

namespace Sandersao\FileTransfer\System;

use DI\Container;
use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\IO\Exception\InternalException;

class BootstrapSystem
{
    private Container $container;
    private DispatchSystem $dispatchSystem;
    private ResponseSystem $responseSystem;
    private RouteCollector $collection;

    public function __construct(
        DispatchSystem $dispatchSystem,
        ResponseSystem $responseSystem,
        RouteCollector $collection,
    ) {
        $this->dispatchSystem = $dispatchSystem;
        $this->responseSystem = $responseSystem;
        $this->collection = $collection;
    }

    public function setContainer(Container $container){
        $this->container = $container;
    }

    public function route()
    {
        $collection = $this->collection;
        $responseSystem = $this->responseSystem;
        if(empty($this->container)){
            throw new InternalException('No container in the bootstrap system');
        }
        $container = $this->container;
        require realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' )  . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'route.php';
        $this->dispatchSystem->dispatch($collection);
    }
}
