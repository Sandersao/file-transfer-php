<?php

namespace Sandersao\FileTransfer\IO\Response;

class FolderResponse extends DirectoryResponse
{
    public function getName()
    {
        $name = explode(DIRECTORY_SEPARATOR, $this->path);
        return end($name);
    }

    public function getItemCount(): int {
        if($this->path){
            return count($this->getFileListRaw());
        }
        return 0;
    }

    public function getFileCount(): int {
        $itemList = $this->getFileListRaw();
        $itemList = array_filter($itemList, function ($item){
            return is_file($this->path . DIRECTORY_SEPARATOR . $item);
        });
        return count($itemList);
    }

    public function getFolderCount(): int {
        $itemList = $this->getFileListRaw();
        $itemList = array_filter($itemList, function ($item){
            return is_dir($this->path . DIRECTORY_SEPARATOR . $item);
        });
        return count($itemList);
    }

    /** @return array<int, string> */
    private function getFileListRaw(): array{
        return array_diff(scandir($this->path), ['.', '..']);
    }
}
