<?php

namespace Sandersao\FileTransfer\IO\Response;

class NavResponse extends DirectoryResponse
{
    /** @var array<int, FolderResponse> $folderList */
    public array $folderList = [];
    /** @var array<int, FileResponse> $fileList */
    public array $fileList = [];

    /** @return array<int, FolderResponse> */
    public function getBreadcrumbList(): array
    {
        if (empty($this->path)) {
            return [];
        }

        $actualPath = $this->path;
        $pathItemList = explode(DIRECTORY_SEPARATOR, $actualPath);
        $pathItemList = array_filter($pathItemList, function ($pathItem) {
            return !empty($pathItem);
        });
        array_pop($pathItemList);
        $pathItemList = array_values($pathItemList);

        $pathList = array_map(function ($pathItem) use ($actualPath) {
            $posicao = strpos($actualPath, $pathItem);

            if ($posicao === false) {
                return false;
            }

            return substr($actualPath, 0, $posicao + strlen($pathItem));
        }, $pathItemList);

        $pathList = array_map(function ($path) {
            return new FolderResponse($path);
        }, $pathList);

        return $pathList;
    }
}
