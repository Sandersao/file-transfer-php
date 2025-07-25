<?php

namespace Sandersao\FileTransfer\Business\Adapter;

use Sandersao\FileTransfer\IO\Exception\InternalException;

class PathAdapter
{
    public function list(string $path)
    {
        $handle = opendir($path);
        if (!$handle) {
            throw new InternalException("Impossible to open the path handdler");
        }

        $pathList = [];
        while (false !== ($entry = readdir($handle))) {
            $pathList[] = $entry;
        }
        closedir($handle);

        return array_diff($pathList, ['.', '..']);
    }
}
