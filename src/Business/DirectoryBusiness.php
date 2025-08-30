<?php

namespace Sandersao\FileTransfer\Business;

use Sandersao\FileTransfer\Business\Adapter\DirectoryAdapter;
use Sandersao\FileTransfer\Config\EnvConfig;
use Sandersao\FileTransfer\IO\Exception\InternalException;
use Sandersao\FileTransfer\IO\Response\DirectoryResponse;

class DirectoryBusiness
{
    private DirectoryAdapter $adapter;
    private EnvConfig $envConfig;
    public function __construct(
        DirectoryAdapter $adapter,
        EnvConfig $envConfig
    ) {
        $this->adapter = $adapter;
        $this->envConfig = $envConfig;
    }

    /** @return array<int, DirectoryResponse> */
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

    public function get(string $pathString, string | null $childPath = null): DirectoryResponse
    {
        $path = new DirectoryResponse($pathString, $childPath);

        if(!$path->isValid()){
            $pathName = $path->getName();
            throw new InternalException("Impossível encontrar o pasta ou arquivo $pathName");
        }

        return $path;
    }
}
