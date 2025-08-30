<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\Business\Adapter\FileAdapter;
use Sandersao\FileTransfer\IO\Exception\InternalException;
use Sandersao\FileTransfer\IO\Response\FilePreviewNone;
use Sandersao\FileTransfer\IO\Response\FileResponse;

class FileBusiness
{
    private FileAdapter $adapter;
    private DirectoryBusiness $directoryBusiness;

    public function __construct(FileAdapter $adapter, DirectoryBusiness $directoryBusiness)
    {
        $this->adapter = $adapter;
        $this->directoryBusiness = $directoryBusiness;
    }

    /** @return array<int, FileResponse> */
    public function list(string $path)
    {
        $pathList = $this->directoryBusiness->list($path);
        $filePathList = array_filter($pathList, function ($path) {
            return $path->isFile() === true;
        });
        return array_map(function ($dir) {
            return $this->get($dir->path);
        }, $filePathList);
    }

    public function get(string $path): FileResponse
    {
        $file = new FileResponse($path);

        if (!$file->isValid()) {
            $fileName = $file->getName();
            throw new InternalException("Impossible to fetch file: $fileName");
        }

        return $file;
    }

    public function preview(string $path): void
    {
        $file = $this->get($path);
        if (!$file->isFile()) {
            throw new InternalException('This is not a file');
        }
        if ($file->getPreviewType() instanceof FilePreviewNone) {
            throw new InternalException('This file is not previewable');
        }
        $this->adapter->preview($file);
    }

    public function download(string $path): void
    {
        $file = $this->get($path);
        if (!$file->isFile()) {
            throw new InternalException('This is not a file');
        }
        $this->adapter->download($file);
    }
}
