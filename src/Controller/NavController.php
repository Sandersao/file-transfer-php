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

    public function navigate(string | null $path): ResponseSystem
    {
        $navigation = $this->business->get($path);
        $fileList = $this->business->listFile($path);
        $folderList = $this->business->listFolder($path);

        $body = $this->view->import('nav.navigate', [
            'fileList' => $fileList,
            'folderList' => $folderList,
            'navigation' => $navigation,
        ]);

        $response = new ResponseSystem();
        $response->body = $body;
        return $response;
    }
}
