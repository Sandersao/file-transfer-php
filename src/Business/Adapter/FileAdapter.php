<?php

namespace Sandersao\FileTransfer\Business\Adapter;

use Sandersao\FileTransfer\Config\EnvConfig;
use Sandersao\FileTransfer\IO\Exception\InternalException;
use Sandersao\FileTransfer\IO\Response\FileResponse;

class FileAdapter
{
    private EnvConfig $envConfig;
    public function __construct(EnvConfig $envConfig)
    {
        $this->envConfig = $envConfig;
    }

    public function remove(FileResponse $file)
    {
        unlink($file->path);
    }

    public function preview(FileResponse $file)
    {
        $fileMimeType = $file->getMimetype();
        $fileSize = $file->getByteSize();

        $range = null;
        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE']; // exemplo: "bytes=500000-"
        }

        $matches = [];
        if ($range) {
            preg_match('/bytes=(\d*)-(\d*)/', $range, $matches);
        }

        $start = 0;
        $end = $fileSize - 1;

        if (count($matches) > 2 && $matches[1] !== '') {
            $start = intval($matches[1]);
        }
        if (count($matches) > 3 && $matches[2] !== '') {
            $end = intval($matches[2]);
        }

        $contentLentgh = $end - $start + 1;

        header("Content-Type: $fileMimeType");
        header("Accept-Ranges: bytes");
        header("Content-Length: $contentLentgh");
        if ($range) {
            header("HTTP/1.1 206 Partial Content");
            header("Content-Range: bytes $start-$end/$fileSize");
        }

        if (ob_get_level()) {
            ob_end_clean();
        }

        $handle = fopen($file->path, 'rb');
        if ($handle === false) {
            throw new InternalException('Error while trying to open the file');
        }

        if ($range) {
            fseek($handle, $start);
        }

        $blockSize = $this->envConfig->getDownloadBlockSize();
        $bytesSent = 0;
        while (!feof($handle)) {
            $buffer = fread($handle, min($blockSize, $contentLentgh - $bytesSent));
            echo $buffer;
            flush();
            $bytesSent += strlen($buffer);
        }

        fclose($handle);
        flush();
    }

    public function download(FileResponse $file)
    {
        set_time_limit(0);
        ignore_user_abort(true);

        $downloadFileName = $file->getName();
        $fileSize = $file->getByteSize();

        $range = null;
        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE']; // exemplo: "bytes=500000-"
        }

        $matches = [];
        if ($range) {
            preg_match('/bytes=(\d*)-(\d*)/', $range, $matches);
        }

        $start = 0;
        $end = $fileSize - 1;

        if (count($matches) > 2 && $matches[1] !== '') {
            $start = intval($matches[1]);
        }
        if (count($matches) > 3 && $matches[2] !== '') {
            $end = intval($matches[2]);
        }

        $contentLentgh = $end - $start + 1;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"$downloadFileName\"");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        header("Content-Length: $contentLentgh");
        if ($range) {
            header("HTTP/1.1 206 Partial Content");
            header("Content-Range: bytes $start-$end/$fileSize");
        }

        if (ob_get_level()) {
            ob_end_clean();
        }

        ini_set('output_buffering', 'off');
        ini_set('zlib.output_compression', 'Off');

        $handle = fopen($file->path, 'rb');
        if ($handle === false) {
            throw new InternalException('Error while trying to open the file');
        }

        if ($range) {
            fseek($handle, $start);
        }

        $blockSize = $this->envConfig->getDownloadBlockSize();
        $bytesSent = 0;
        while (!feof($handle) && $bytesSent < $contentLentgh) {
            $buffer = fread($handle, min($blockSize, $contentLentgh - $bytesSent));
            echo $buffer;
            @ob_flush(); flush();
            $bytesSent += strlen($buffer);
        }
        fclose($handle);
        flush();
    }
}
