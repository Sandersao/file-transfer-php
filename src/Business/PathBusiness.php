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
                $pathResponse = new PathResponse();
                $pathResponse->path = $childPath;
                $pathResponse->subpath = $childPath;
                $pathResponse->isFile = false;
                return $pathResponse;
            }, $this->envConfig->getPathList());
        }

        return array_map(function ($childPath) use ($path) {
            $fullPath = $path . DIRECTORY_SEPARATOR . $childPath;

            $pathResponse = new PathResponse();

            $pathResponse->subpath = $childPath;

            $pathResponse->path = realpath($fullPath);
            $shouldReturnRoot = $childPath == '..' && in_array($path, $this->envConfig->getPathList());
            if ($shouldReturnRoot) {
                $pathResponse->path = '';
            }

            $pathResponse->isFile = null;
            if (is_file($fullPath)) {
                $pathResponse->isFile = true;
            }
            if (is_dir($fullPath)) {
                $pathResponse->isFile = false;
            }

            if($pathResponse->isFile === true){
                $pathResponse->action = new PathAction();
                $pathResponse->action->read = true;
                $pathResponse->action->download = true;
            }

            if($pathResponse->isFile === false){
                $pathResponse->action = new PathAction();
                $pathResponse->action->read = true;
                $pathResponse->action->download = true;
            }

            return $pathResponse;
        }, $this->adapter->list($path));
    }
}
