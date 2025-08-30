<?php

use Sandersao\FileTransfer\Config\EnvConfig;
use Sandersao\FileTransfer\IO\Response\FilePreviewAudio;
use Sandersao\FileTransfer\IO\Response\FilePreviewIframe;
use Sandersao\FileTransfer\IO\Response\FilePreviewImage;
use Sandersao\FileTransfer\IO\Response\FilePreviewNone;
use Sandersao\FileTransfer\IO\Response\FilePreviewVideo;
use Sandersao\FileTransfer\IO\Response\FileResponse;
use Sandersao\FileTransfer\IO\Response\NavResponse;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <?php /** @var NavResponse $navigation */ ?>
            <h2>Diretório: <?= $navigation->path ?></h2>
        </div>
    </div>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php if (!empty($navigation->path)): ?>
                <li class="breadcrumb-item active">
                    <div class="btn btn-outline-dark" name="access" path="">Início</div>
                </li>
            <?php endif; ?>
            <?php foreach ($navigation->getBreadcrumbList() as $breadcrumbItem) : ?>
                <li class="breadcrumb-item">
                    <div class="btn btn-outline-dark" name="access" path="<?= $breadcrumbItem->getPathEncoded() ?>">
                        <?= $breadcrumbItem->getName() ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </nav>
    <?php if ($navigation->getPreviousDirEncoded() !== null) : ?>
        <div class="row">
            <div class="col">
                <div class="btn btn-outline-secondary" name="access" path="<?= $navigation->getPreviousDirEncoded() ?>">Voltar</div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <h3>Pastas</h3>
        </div>
    </div>
    <div class="row">
        <?php if (count($navigation->folderList) === 0) : ?>
            <div class="col-12 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sem pastas aqui</h5>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($navigation->folderList as $folder) : ?>
            <div class="col-12 col-md-6 col-lg-3 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            Caminho: <?= $folder->path ? $folder->path : 'Voltar ao início' ?>
                        </p>

                        <p class="card-text">
                            Pastas: <?= $folder->getFolderCount() ?>
                        </p>
                        <p class="card-text">
                            Diretórios: <?= $folder->getFileCount() ?>
                        </p>

                        <?php if ($folder->subpath == '..') : ?>
                            <div class="btn btn-info" name="access" path="<?= $folder->getPathEncoded() ?>">Voltar</div>
                        <?php endif; ?>

                        <?php if ($folder->subpath != '..') : ?>
                            <div class="btn btn-primary" name="access" path="<?= $folder->getPathEncoded() ?>">Acessar</div>
                        <?php endif; ?>

                        <?php if ($folder->getPathEncoded() && $folder->getSubpath() != '..' && false) : ?>
                            <span class="btn btn-success" name="download-folder" path="<?= $folder->getPathEncoded() ?>">Download</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="col">
            <h3>Arquivos</h3>
        </div>
    </div>
    <div class="row">
        <?php if (count($navigation->fileList) == 0) : ?>
            <div class="col-12 mb-3 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sem arquivos aqui</h5>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($navigation->fileList as $file) : ?>
            <div class="col-12 col-md-6 col-lg-3 mb-3 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            Nome: <?= $file->getName() ?>
                        </p>

                        <p class="card-text">
                            Tamanho: <?= $file->getSize() ?>
                        </p>
                        <?php if ($file->getPathEncoded() && $file->subpath != '..') : ?>
                            <span class="btn btn-success" name="download-file" path="<?= $file->getPathEncoded() ?>">Download</span>
                        <?php endif; ?>
                        <?php if (!($file->getPreviewType() instanceof FilePreviewNone)) : ?>
                            <button class="btn btn-info" name="preview" path="<?= $file->getPathEncoded() ?>" alt="Preview">Preview</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    navegar = (target) => {
        const path = target.getAttribute('path')
        const uri = path ? `/navigate?path=${path}` : '/navigate'
        window.location.href = uri
    }
    document.querySelectorAll('[name="access"]').forEach(e => e.addEventListener('click', (e) => navegar(e.target)))

    downloadFile = (target) => {
        const path = target.getAttribute('path')
        const uri = `/file/download?path=${path}`
        window.open(uri, '_blank').focus();
    }
    document.querySelectorAll('[name="download-file"]').forEach(e => e.addEventListener('click', (e) => downloadFile(e.target)))

    previsualizar = (target) => {
        let path = target.getAttribute('path')
        const uri = `/file/preview?path=${path}`
        window.open(uri, '_blank').focus();
    }
    document.querySelectorAll('[name="preview"]').forEach(e => e.addEventListener('click', (e) => previsualizar(e.target)))
</script>
<?php
