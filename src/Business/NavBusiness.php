<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\NavResponse;

class NavBusiness
{
    private FileBusiness $fileBusiness;
    private FolderBusiness $folderBusiness;
    private PathBusiness $pathBusiness;
    public function __construct(
        FileBusiness $fileBusiness,
        FolderBusiness $folderBusiness,
        PathBusiness $pathBusiness
    ) {
        $this->fileBusiness = $fileBusiness;
        $this->folderBusiness = $folderBusiness;
        $this->pathBusiness = $pathBusiness;
    }

    public function navigate(string | null $path): NavResponse
    {
        $navResponse = new NavResponse();
        $navResponse->fileList = $this->fileBusiness->list($path);
        $navResponse->folderList = $this->folderBusiness->list($path);

        $navResponse->previousDir = null;
        if (!empty($path)) {
            $navResponse->previousDir = $this->pathBusiness->getPreviousDir($path);
            $navResponse->previousDirEncoded = urlencode($navResponse->previousDir);
        }
        return $navResponse;
    }
}
