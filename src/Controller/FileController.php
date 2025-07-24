<?php

namespace Sandersao\FileTransfer\Controller;

use Sandersao\FileTransfer\Business\FileBusiness;
use Sandersao\FileTransfer\IO\Exception\InternalException;
use Sandersao\FileTransfer\IO\Response\FilePreviewType;
use Sandersao\FileTransfer\System\ResponseSystem;

class FileController
{
    private FileBusiness $business;
    public function __construct(FileBusiness $business) {
        $this->business = $business;
    }


    public function preview(string | null $path): ResponseSystem
    {
        $file = $this->business->get($path);
        if (!$file->previewType == FilePreviewType::$none) {
            throw new InternalException('This file is not previewable');
        }
        $file = $this->business->getBinaryData($file);
        $file = $this->business->getMimetype($file);

        $response = new ResponseSystem();
        $response->header = [
            "Content-Type: $file->mimetype"
        ];
        $response->body = $file->binaryes;
        return $response;
    }
}
