<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\FileResponse;
use Sandersao\FileTransfer\IO\Response\PathResponse;

class FileBusiness
{
    private array $previewableExtList = ['png', 'pdf', 'mp4', 'jpg'];
    private PathBusiness $pathBusiness;
    public function __construct(
        PathBusiness $pathBusiness
    ) {
        $this->pathBusiness = $pathBusiness;
    }

    /** @return array<int, FileResponse> */
    public function list(string | null $path)
    {
        $pathList = $this->pathBusiness->list($path);
        $filePathList = array_filter($pathList, function ($path) {
            return $path->isFile === true;
        });
        return array_map(function ($path) {
            return $this->get($path);
        }, $filePathList);
    }

    public function get(string | PathResponse $path)
    {
        if (!($path instanceof PathResponse)) {
            $path = $this->pathBusiness->get($path);
        }

        $file = new FileResponse($path);
        $file->path = $path->path;
        $file->subpath = $path->subpath;
        $file->name = $path->name;

        $ext = explode(".", $path->name);
        $ext = end($ext);
        $file->ext = $ext;

        $size = filesize($path->path);
        $file->byteSize = $size;

        $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($size >= 1024 && $i < count($unidades) - 1) {
            $size /= 1024;
            $i++;
        }
        $file->size = round($size, 2) . ' ' . $unidades[$i];

        if (in_array($ext, $this->previewableExtList)) {
            $file->isPreviewable = true;
        }

        return $file;
    }
}
