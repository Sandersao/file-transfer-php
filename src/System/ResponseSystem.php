<?php

namespace Sandersao\FileTransfer\System;

class ResponseSystem
{
    public function provide(string | array | null $reponse): void
    {
        if (empty($reponse)) {
            return;
        }

        $this->show($reponse);
    }

    public function show(string | array $reponse){
        if(gettype($reponse) === 'array'){
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($reponse, JSON_PRETTY_PRINT);
            flush();
            return;
        }

        if(gettype($reponse) === 'string'){
            header('Content-Type: text/html; charset=UTF-8');
            echo $reponse;
            flush();
            return;
        }

        echo '{"error": "No response detected!"}';
    }

    public function redirect(string $uri){
        echo "<script>window.location.href = '$uri';</script>";
        die();
    }
}
