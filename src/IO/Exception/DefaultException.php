<?php

namespace Sandersao\FileTransfer\IO\Exception;

use Exception;

class DefaultException extends Exception
{
    public array | null $data = null;
    public function __construct(string $message, int $code, array | null $data = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }
}
