<?php

namespace Sandersao\FileTransfer\Controller;

use Sandersao\FileTransfer\Business\NavBusiness;
use Sandersao\FileTransfer\System\ResponseSystem;
use Sandersao\FileTransfer\System\ViewSystem;

class NavController
{
    private NavBusiness $business;
    private ViewSystem $view;
    public function __construct(
        NavBusiness $business,
        ViewSystem $view
    ) {
        $this->business = $business;
        $this->view = $view;
    }

    public function navigate(string | null $path): string
    {
        $navigation = $this->business->get($path);

        return $this->view->import('nav.navigate', [
            'navigation' => $navigation
        ]);
    }
}
