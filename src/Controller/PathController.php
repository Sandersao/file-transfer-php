<?php

namespace Sandersao\FileTransfer\Controller;

use Sandersao\FileTransfer\Business\PathBusiness;
use Sandersao\FileTransfer\System\ViewSystem;

class PathController
{
    private PathBusiness $business;
    private ViewSystem $view;
    public function __construct(
        PathBusiness $business,
        ViewSystem $view
    ) {
        $this->business = $business;
        $this->view = $view;
    }

    public function listView(string | null $path)
    {
        $pathList = $this->business->list($path);
        $this->view->import('path.list', ['pathList' => $pathList, 'parentPath' => $path]);
    }
}
