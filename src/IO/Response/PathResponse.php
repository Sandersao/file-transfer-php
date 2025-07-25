<?php

namespace Sandersao\FileTransfer\IO\Response;

class PathResponse
{
    public string $path;
    public string $subpath;
    public string $name;
    public bool | null $isFile;
}
