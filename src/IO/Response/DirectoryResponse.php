<?php

namespace Sandersao\FileTransfer\IO\Response;

class DirectoryResponse
{
    /** @var array<int,string> $rootPathList */
    private array $rootPathList = [];
    public string | null $path = null;
    public string | null $subpath = null;

    public function __construct(string | null $pathString, string | null $childPath = null)
    {
        if (empty($pathString)) {
            return $this;
        }

        if (empty($childPath)) {
            $this->path = realpath($pathString);
            $this->subpath = $pathString;
            return $this;
        }

        $this->path = realpath($pathString . DIRECTORY_SEPARATOR . $childPath);
        $this->subpath = $childPath;
    }

    public function getPathEncoded(): string
    {
        return urlencode($this->path);
    }

    public function getSubpath(): string
    {
        return str_replace($this->rootPathList, '', $this->path);
    }

    public function getSubpathEncoded(): string
    {
        return urlencode($this->getSubpath());
    }

    public function getPreviousDir()
    {
        if (in_array($this->path, $this->rootPathList)) {
            return '';
        }
        return realpath($this->path . DIRECTORY_SEPARATOR . '..');
    }

    public function getPreviousDirEncoded(): string
    {
        return urlencode($this->getPreviousDir());
    }

    public function getName()
    {
        $name = explode(DIRECTORY_SEPARATOR, $this->path);
        return end($name);
    }

    public function isValid()
    {
        if (!is_file($this->path) && !is_dir($this->path)) {
            return false;
        }
        return true;
    }

    public function isFile()
    {
        if (is_file($this->path)) {
            return true;
        }
        if (is_dir($this->path)) {
            return false;
        }
    }

    /** @param array<int, string> $rootPathList */
    public function setRootPathList(array $rootPathList): void
    {
        $this->rootPathList = $rootPathList;
    }
}
