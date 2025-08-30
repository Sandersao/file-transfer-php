<?php

namespace Sandersao\FileTransfer\Controller;

use Sandersao\FileTransfer\Business\FileBusiness;
use Sandersao\FileTransfer\IO\Exception\InternalException;
use Sandersao\FileTransfer\IO\Response\FilePreviewNone;
use Sandersao\FileTransfer\IO\Response\FilePreviewType;
use Sandersao\FileTransfer\System\ResponseSystem;

class FileController
{
    private FileBusiness $business;
    public function __construct(FileBusiness $business) {
        $this->business = $business;
    }


    public function preview(string $path): void
    {
        $this->business->preview($path);
    }

    public function download(string $path): void
    {
        $this->business->download($path);
    }
}
