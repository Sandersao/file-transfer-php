<?php

namespace Sandersao\FileTransfer\IO\Response;

class FilePreviewType {
    public static $video = 'video';
    public static $image = 'image';
    public static $audio = 'audio';
    public static $iframe = 'iframe';
    public static $none = 'none';
}

class FileResponse
{
    public string $path;
    public string $encodedPath;
    public string $subpath;
    public string $name;
    public string $ext;
    public string $mimetype;
    public int $byteSize;
    public string $size;
    public string $previewType;
    public string | null $binaryes = null;
}
