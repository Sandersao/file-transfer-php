<?php

namespace Sandersao\FileTransfer\IO\Response;

class FileResponse
{
    public string $path;
    public string $subpath;
    public string $name;
    public string $ext;
    public bool $isPreviewable = false;
}
