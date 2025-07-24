<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\FolderResponse;

class FolderBusiness
{
    private PathBusiness $pathBusiness;
    public function __construct(
        PathBusiness $pathBusiness
    ) {
        $this->pathBusiness = $pathBusiness;
    }

    /** @return array<int, FolderResponse> */
    public function list(string | null $path) {
        $pathList = $this->pathBusiness->list($path);
        $filePathList = array_filter($pathList, function ($path) {
            return $path->isFile === false;
        });
        return array_map(function ($path) {
            $folder = new FolderResponse();
            $folder->path = $path->path;
            $folder->subpath = $path->subpath;
            $folder->name = $path->name;

            $arquivoList = array_diff(scandir($path->path), ['.', '..']);
            $folder->fileCount = count($arquivoList);
            return $folder;
        }, $filePathList);
    }
}
