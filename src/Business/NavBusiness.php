<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\NavResponse;
use Sandersao\FileTransfer\IO\Response\PathResponse;

class NavBusiness
{
    private FileBusiness $fileBusiness;
    private FolderBusiness $folderBusiness;
    public function __construct(
        FileBusiness $fileBusiness,
        FolderBusiness $folderBusiness
    ) {
        $this->fileBusiness = $fileBusiness;
        $this->folderBusiness = $folderBusiness;
    }

    /** @return NavResponse */
    public function list(string | null $path): NavResponse
    {
        $navResponse = new NavResponse();
        $navResponse->fileList = $this->fileBusiness->list($path);
        $navResponse->folderList = $this->folderBusiness->list($path);
        return $navResponse;
    }
}
