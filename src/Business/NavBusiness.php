<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\IO\Response\NavResponse;
use Sandersao\FileTransfer\IO\Response\PathResponse;

class NavBusiness
{
    private FileBusiness $fileBusiness;
    private FolderBusiness $folderBusiness;
    private PathBusiness $pathBusiness;
    public function __construct(
        FileBusiness $fileBusiness,
        FolderBusiness $folderBusiness,
        PathBusiness $pathBusiness
    ) {
        $this->fileBusiness = $fileBusiness;
        $this->folderBusiness = $folderBusiness;
        $this->pathBusiness = $pathBusiness;
    }

    public function get(string | null $path): NavResponse
    {
        $navResponse = new NavResponse();

        $navResponse->path = $path;

        $navResponse->breadcrumb = $this->generateBreadcrumb($path);

        if (!empty($path)) {
            $navResponse->previousDir = $this->pathBusiness->getPreviousDir($path);
            $navResponse->previousDirEncoded = urlencode($navResponse->previousDir) ?? '';
        }

        return $navResponse;
    }

    public function listFile(string | null $path): array
    {
        return $this->fileBusiness->list($path);
    }

    public function listFolder(string | null $path): array
    {
        return $this->folderBusiness->list($path);
    }

    /** @return array<int, FolderResponse> */
    private function generateBreadcrumb(string | null $path): array
    {
        $pathList = [];
        if (!empty($path)) {
            $pathList = $this->pathBusiness->getSubpath($path);
            $pathList = explode(DIRECTORY_SEPARATOR, $pathList);
            $pathList = array_filter($pathList, function ($path) {
                return !empty($path);
            });
            $pathList = array_values($pathList);
        }

        $pathList = array_map(function ($pathItem) use ($path) {
            $posicao = strpos($path, $pathItem);

            if ($posicao === false) {
                return false;
            }
            return substr($path, 0, $posicao + strlen($pathItem));
        }, $pathList);

        $pathList = array_map(function ($path) {
            return $this->folderBusiness->get($path);
        }, $pathList);

        return $pathList;
    }
}
