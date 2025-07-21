<?php

namespace Sandersao\FileTransfer\Controller;

use Sandersao\FileTransfer\Config\DirConfig;
use Sandersao\FileTransfer\System\ViewSystem;

class FileController
{
    private ViewSystem $view;
    private DirConfig $dirConfig;
    public function __construct(ViewSystem $view, DirConfig $dirConfig)
    {
        $this->view = $view;
        $this->dirConfig = $dirConfig;
    }

    public function list()
    {
        $fileList = $this->apiList();
        $this->view->import('file.list', ['fileList' => $fileList]);
    }

    /** @return array<int, string> */
    public function apiList(): array
    {
        $dirList = $this->dirConfig->getPathList();
        $fileList = [];
        foreach ($dirList as $dir) {
            if ($handle = opendir($dir)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry == "." && $entry == "..") {
                        continue;
                    }
                    $fileList[] = $entry;
                }
                closedir($handle);
            }
        }
        return $fileList;
    }
}
