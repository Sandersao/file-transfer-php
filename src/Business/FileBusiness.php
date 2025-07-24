<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\FilePreviewType;
use Sandersao\FileTransfer\IO\Response\FileResponse;
use Sandersao\FileTransfer\IO\Response\PathResponse;

class FileBusiness
{
    private array $imageExtList = ['png', 'jpg'];
    private array $videoExtList = ['mp4'];
    private array $audioExtList = ['ogg'];
    private array $iframeExtList = ['pdf'];
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
        $file->encodedPath = urlencode($path->path);
        $file->subpath = $path->subpath;
        $file->name = $path->name;

        $ext = explode(".", $path->name);
        $ext = end($ext);
        $ext = strtolower($ext);
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

        $file->previewType = FilePreviewType::$none;
        if (in_array($ext, $this->imageExtList)) {
            $file->previewType = FilePreviewType::$image;
        }
        if (in_array($ext, $this->audioExtList)) {
            $file->previewType = FilePreviewType::$audio;
        }
        if (in_array($ext, $this->videoExtList)) {
            $file->previewType = FilePreviewType::$video;
        }
        if (in_array($ext, $this->iframeExtList)) {
            $file->previewType = FilePreviewType::$iframe;
        }

        return $file;
    }

    public function getBinaryData(FileResponse $file): FileResponse
    {
        $file->binaryes = file_get_contents($file->path);
        return $file;
    }

    public function getMimetype(FileResponse $file): FileResponse
    {
        $file->mimetype = mime_content_type($file->path);
        return $file;
    }
}
