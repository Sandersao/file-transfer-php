<?php

namespace Sandersao\FileTransfer\IO\Response;

class FolderResponse
{
    public string $path;
    public string $encodedPath;
    public string $subpath;
    public string $name;
    public int $itemCount;
}
