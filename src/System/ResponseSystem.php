<?php

namespace Sandersao\FileTransfer\System;

class ResponseSystem
{
    public string | array | null $header = null;
    public array | string $body;

    public function provide(): void {
        if ($this->header !== null && gettype($this->header) == 'string') {
            header($this->header);
            echo $this->body;
            return;
        }

        if ($this->header !== null && gettype($this->header) == 'array') {
            foreach ($this->header as $headerItem) {
                header($headerItem);
            }
            echo $this->body;
            return;
        }
        if (is_array($this->body)) {
            $this->prepareHeaderJson();
            echo json_encode($this->body);
            return;
        }

        $this->prepararHeaderHtml();
        echo $this->body;
    }

    public function prepareHeaderJson()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }

    public function prepararHeaderHtml()
    {
        header('Content-Type: text/html; charset=UTF-8');
    }
}
