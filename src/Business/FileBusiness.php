<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\FileResponse;

class FileBusiness
{
    private PathBusiness $pathBusiness;
    public function __construct(
        PathBusiness $pathBusiness
    ) {
        $this->pathBusiness = $pathBusiness;
    }

    /** @return array<int, FileResponse> */
    public function list(string $path) {
        $pathList = $this->pathBusiness->list($path);
        $filePathList = array_filter($pathList, function ($path) {
            return $path->isFile === false;
        });
        return array_map(function ($path) {
            $file = new FileResponse($path);
            $file->path = $path->path;
            $file->subpath = $path->subpath;
            $file->name = $path->name;

            $ext = explode("\.", $path->name);
            $ext = end($ext);
            $file->ext = $ext;

            if(in_array($ext, ['png', 'pdf'])){
                $file->isPreviewable = true;
            }

            return $file;
        }, $filePathList);
    }
}
