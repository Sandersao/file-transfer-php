<?php

namespace Sandersao\FileTransfer\IO\Response;

class FileResponse
{
    public string $path;
    public string $subpath;
    public string $name;
    public string $ext;
    public int $byteSize;
    public string $size;
    public bool $isPreviewable = false;
    public string | null $binaryes = null;

    public function getBinary(){
        $this->binaryes = file_get_contents($this->path);
    }
}
