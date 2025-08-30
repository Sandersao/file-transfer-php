<?php

namespace Sandersao\FileTransfer\IO\Response;

class FilePreview {}
class FilePreviewImage extends FilePreview {}
class FilePreviewVideo extends FilePreview {}
class FilePreviewAudio extends FilePreview {}
class FilePreviewIframe extends FilePreview {}
class FilePreviewNone extends FilePreview {}

class FileResponse extends DirectoryResponse
{
    private array $imageExtList = ['png', 'jpg'];
    private array $videoExtList = ['mp4'];
    private array $audioExtList = ['ogg'];
    private array $iframeExtList = ['pdf'];

    public function getExtension(): string
    {
        $ext = explode(".", $this->getName());
        $ext = end($ext);
        return strtolower($ext);
    }

    public function getBinaryDataFull(): string
    {
        return file_get_contents($this->path);
    }

    public function getMimetype(): string
    {
        return mime_content_type($this->path);
    }

    public function getByteSize(): int
    {
        return filesize($this->path);
    }

    public function getSize(): string
    {
        $size = filesize($this->path);
        $unityList = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($size >= 1024 && $i < count($unityList) - 1) {
            $size /= 1024;
            $i++;
        }
        $roudedSize = round($size, 2);
        $unity = $unityList[$i];
        return "$roudedSize $unity";
    }

    public function getPreviewType(): FilePreview
    {
        $previewType = new FilePreviewNone();
        if (in_array($this->getExtension(), $this->imageExtList)) {
            $previewType = new FilePreviewImage();
        }
        if (in_array($this->getExtension(), $this->audioExtList)) {
            $previewType = new FilePreviewAudio();
        }
        if (in_array($this->getExtension(), $this->videoExtList)) {
            $previewType = new FilePreviewVideo();
        }
        if (in_array($this->getExtension(), $this->iframeExtList)) {
            $previewType = new FilePreviewIframe();
        }
        return $previewType;
    }
}
