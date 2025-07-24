<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\Business\Adapter\PathAdapter;
use Sandersao\FileTransfer\Config\EnvConfig;
use Sandersao\FileTransfer\IO\Response\PathAction;
use Sandersao\FileTransfer\IO\Response\PathResponse;

class PathBusiness
{
    private PathAdapter $adapter;
    private EnvConfig $envConfig;
    public function __construct(
        PathAdapter $adapter,
        EnvConfig $envConfig
    ) {
        $this->adapter = $adapter;
        $this->envConfig = $envConfig;
    }

    /** @return array<int, PathResponse> */
    public function list(string | null $path): array
    {
        if (!$path) {
            return array_map(function ($childPath) {
                $path = new PathResponse();
                $path->path = $childPath;
                $path->subpath = $childPath;
                $path->isFile = false;

                $name = explode(DIRECTORY_SEPARATOR, $path->path);
                $name = end($name);
                $path->name = $name;
                return $path;
            }, $this->envConfig->getPathList());
        }

        return array_map(function ($childPath) use ($path) {
            $fullPath = $path . DIRECTORY_SEPARATOR . $childPath;

            $path = new PathResponse();

            $path->subpath = $childPath;

            $path->path = realpath($fullPath);
            $shouldReturnRoot = $childPath == '..' && in_array($path, $this->envConfig->getPathList());
            if ($shouldReturnRoot) {
                $path->path = '';
            }

            $name = explode(DIRECTORY_SEPARATOR, $path->path);
            $name = end($name);
            $path->name = $name;

            $path->isFile = null;
            if (is_file($fullPath)) {
                $path->isFile = true;
            }
            if (is_dir($fullPath)) {
                $path->isFile = false;
            }

            return $path;
        }, $this->adapter->list($path));
    }
}
