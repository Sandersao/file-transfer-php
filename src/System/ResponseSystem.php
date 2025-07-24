<?php

namespace Sandersao\FileTransfer\System;

class ResponseSystem
{
    public string | null $header = null;
    public array | string $body;

    public function provide(): void {
        if ($this->header !== null){
            header($this->header);
            echo $this->body;
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
