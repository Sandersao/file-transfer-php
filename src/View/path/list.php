<?php /** @var array<int, Sandersao\FileTransfer\IO\Response\PathResponse;> $pathList */?>
<?php foreach($pathList as $path) : ?>
    <?php if($path->isFile === true) : ?>
        <div><?= $path->path ?></div>
    <?php endif; ?>
    <?php if($path->isFile === false) : ?>
        <a href="/path?path=<?= $path->path ? realpath($path->path) : '' ?>">
        <div><?= $path->subpath ?></div>
        </a>
    <?php endif; ?>
<?php endforeach; ?>
