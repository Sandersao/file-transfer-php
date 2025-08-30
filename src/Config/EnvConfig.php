<?php

namespace Sandersao\FileTransfer\Config;

use Dotenv\Dotenv;

class EnvConfig
{
    public function __construct()
    {
        $src = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
        $dotenv = Dotenv::createImmutable($src);
        $dotenv->load();
    }

    /** @return array<int, string> */
    public function getPathList(): array
    {
        $raw = explode(',', $_ENV['DEFAULT_PATH_LIST'] ?? '');
        return array_filter($raw, function ($path) {
            return !empty($path);
        });
    }

    /** @return int */
    public function getDownloadBlockSize(): int
    {
        return intval( $_ENV['DEFAULT_DOWNLOAD_BLOCK_SIZE'] ?? '8192');
    }
}
