<?php

namespace Sandersao\FileTransfer\System;

use Phroute\Phroute\RouteCollector;
use Sandersao\FileTransfer\Config\RouterConfig;

class RouterSystem
{
    public RouteCollector $collection;

    public function __construct(RouteCollector $collection, RouterConfig $routerConfig)
    {
        $this->collection = $collection;
        $routerConfig->route($collection);
    }
}
