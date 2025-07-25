<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\Business\Adapter\PathAdapter;
use Sandersao\FileTransfer\Config\EnvConfig;
use Sandersao\FileTransfer\IO\Exception\InternalException;
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
                if(!is_dir($childPath)){
                    throw new InternalException("Não foi possível acessar o diretório $childPath");
                }
                return $this->get($childPath);
            }, $this->envConfig->getPathList());
        }

        return array_map(function ($childPath) use ($path) {
            return $this->get($path, $childPath);
        }, $this->adapter->list($path));
    }

    public function get(string $pathString, string | null $childPath = null): PathResponse
    {
        $path = new PathResponse();

        if ($childPath) {
            $fullPath = $pathString . DIRECTORY_SEPARATOR . $childPath;
            $path->subpath = $childPath;
        }

        if (!$childPath){
            $fullPath = $pathString;
            $path->subpath = $pathString;
        }

        $path->path = realpath($fullPath);

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
    }

    public function getPreviousDir(string $path){
        if (in_array($path, $this->envConfig->getPathList())){
            return '';
        }
        return realpath($path . DIRECTORY_SEPARATOR . '..');
    }
}
