<?php

namespace Sandersao\FileTransfer\IO\Response;

/**
 * @param array<int, FolderResponse> $breadcrumb
 */
class NavResponse
{
    public string | null $path;
    public array $breadcrumb;
    public string | null $previousDir = null;
    public string | null $previousDirEncoded = null;
}
