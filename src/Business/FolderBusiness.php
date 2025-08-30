<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\FolderResponse;

class FolderBusiness
{
    private DirectoryBusiness $directoryBusiness;
    public function __construct(
        DirectoryBusiness $directoryBusiness
    ) {
        $this->directoryBusiness = $directoryBusiness;
    }

    /** @return array<int, FolderResponse> */
    public function list(string | null $pathString): array
    {
        $pathList = $this->directoryBusiness->list($pathString);
        $folderResponseList = array_map(function ($path) {
            return new FolderResponse($path->path);
        }, $pathList);

        $folderResponseList = array_filter($folderResponseList, function ($path) {
            return $path->isFile() === false;
        });

        return array_values($folderResponseList);
    }
}
