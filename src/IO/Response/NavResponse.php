<?php

namespace Sandersao\FileTransfer\IO\Response;

/**
 * @param array<int, FileResponse> $fileList
 * @param array<int, FolderResponse> $folderList
 */
class NavResponse
{
    public array $fileList;
    public array $folderList;
    public string | null $previousDir;
    public string | null $previousDirEncoded;
}
