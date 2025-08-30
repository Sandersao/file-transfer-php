<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\Config\EnvConfig;
use Sandersao\FileTransfer\IO\Response\NavResponse;

class NavBusiness
{
    private FileBusiness $fileBusiness;
    private FolderBusiness $folderBusiness;
    private EnvConfig $env;

    public function __construct(
        FileBusiness $fileBusiness,
        FolderBusiness $folderBusiness,
        EnvConfig $env
    ) {
        $this->fileBusiness = $fileBusiness;
        $this->folderBusiness = $folderBusiness;
        $this->env = $env;
    }

    public function get(string | null $path): NavResponse
    {
        $nav = new NavResponse($path);

        $nav->setRootPathList($this->env->getPathList());

        $nav->folderList = $this->folderBusiness->list($path);

        if (!empty($path)) {
            $nav->fileList = $this->fileBusiness->list($path);
        }

        return $nav;
    }
}
