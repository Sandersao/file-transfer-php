<?php

namespace Sandersao\FileTransfer\IO\Exception;

class NotFoundException extends DefaultException
{
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->code = 404;
    }
}
