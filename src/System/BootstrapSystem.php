<?php

namespace Sandersao\FileTransfer\System;

class BootstrapSystem
{
    private RouterSystem $router;
    private DispatcherSystem $dispatcher;

    public function __construct(RouterSystem $router, DispatcherSystem $dispatcher)
    {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
    }

    public function start()
    {
        $this->dispatcher->dispatch($this->router->collection);
    }
}
