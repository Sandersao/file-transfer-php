<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\FolderResponse;
use Sandersao\FileTransfer\IO\Response\PathResponse;

class FolderBusiness
{
    private PathBusiness $pathBusiness;
    public function __construct(
        PathBusiness $pathBusiness
    ) {
        $this->pathBusiness = $pathBusiness;
    }

    /** @return array<int, FolderResponse> */
    public function list(string | null $pathString)
    {
        $pathList = $this->pathBusiness->list($pathString);
        $filePathList = array_filter($pathList, function ($path) {
            return $path->isFile === false;
        });
        return array_map(function ($path) {
            return $this->get($path);
        }, $filePathList);
    }

    public function get(string | PathResponse $path): FolderResponse
    {

        if (!($path instanceof PathResponse)) {
            $path = $this->pathBusiness->get($path);
        }

        $folder = new FolderResponse();
        $folder->path = $path->path;
        $folder->encodedPath = urlencode($path->path);
        $folder->subpath = $path->subpath;
        $folder->name = $path->name;

        $folder->itemCount = 0;
        if($path->path){
            $arquivoList = $this->pathBusiness->list($path->path);
            $folder->itemCount = count($arquivoList);
        }
        return $folder;
    }

    public function getPreviousDir(string $path): string
    {
        return realpath($path . DIRECTORY_SEPARATOR . '..');
    }
}
