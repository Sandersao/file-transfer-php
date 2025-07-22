<?php

namespace Sandersao\FileTransfer\IO\Response;

class PathAction {
    public bool $read;
    public bool $download;
}

class PathResponse
{
    public string $path;
    public string $subpath;
    public bool | null $isFile;
    public PathAction $action;
}
