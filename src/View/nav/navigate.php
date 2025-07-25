<?php use Sandersao\FileTransfer\IO\Response\FilePreviewType; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h2>Diretório: <?=$navigation->path?></h2>
        </div>
    </div>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php if(!empty($navigation->path)): ?>
            <li class="breadcrumb-item active">
                <div class="btn btn-outline-dark" name="access" path="">Início</div>
            </li>
            <?php endif; ?>
            <?php foreach($navigation->breadcrumb as $breadcrumbItem) : ?>
                <li class="breadcrumb-item">
                    <div class="btn btn-outline-dark" name="access" path="<?= $breadcrumbItem->encodedPath ?>">
                        <?= $breadcrumbItem->name ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </nav>
    <?php if($navigation->previousDirEncoded !== null) : ?>
        <div class="row">
            <div class="col">
                <div class="btn btn-outline-secondary" name="access" path="<?= $navigation->previousDirEncoded ?>">Voltar</div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <h3>Pastas</h3>
        </div>
    </div>
    <div class="row">
        <?php if (count($folderList) == 0) : ?>
            <div class="col-12 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sem pastas aqui</h5>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($folderList as $folder) : ?>
            <div class="col-12 col-md-6 col-lg-3 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            Caminho: <?= $folder->path ? $folder->path : 'Voltar ao início' ?>
                        </p>

                        <p class="card-text">
                            Itens: <?= $folder->itemCount ?>
                        </p>

                        <?php if ($folder->subpath == '..') : ?>
                            <div class="btn btn-info" name="access" path="<?= $folder->encodedPath ?>">Voltar</div>
                        <?php endif; ?>

                        <?php if ($folder->subpath != '..') : ?>
                            <div class="btn btn-primary" name="access" path="<?= $folder->encodedPath ?>">Acessar</div>
                        <?php endif; ?>

                        <!-- <?php if ($folder->encodedPath && $folder->subpath != '..') : ?>
                            <span class="btn btn-success" name="download" path="<?= $folder->encodedPath ?>">Download</span>
                        <?php endif; ?> -->
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
        <?php if (count($fileList) == 0) : ?>
            <div class="col-12 mb-3 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sem arquivos aqui</h5>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($fileList as $file) : ?>
            <div class="col-12 col-md-6 col-lg-3 mb-3 mb-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <?php if ($file->previewType != FilePreviewType::$none) : ?>
                            <div class="card-img-top btn" name="preview" path="<?= $file->encodedPath ?>">
                                <?php if ($file->previewType == FilePreviewType::$image) : ?>
                                    <img class="d-block w-100" src="/file/preview?path=<?= $file->encodedPath ?>" alt="Preview" disabled>
                                <?php endif; ?>
                                <?php if ($file->previewType == FilePreviewType::$video) : ?>
                                    <video class="w-100" disabled>
                                        <source src="/file/preview?path=<?= $file->encodedPath ?>">
                                        <track label="English" kind="subtitles" srclang="en" src="" default />
                                    </video>
                                <?php endif; ?>
                                <?php if ($file->previewType == FilePreviewType::$iframe) : ?>
                                    <iframe class="w-100 overflow-hidden" src="/file/preview?path=<?= $file->encodedPath ?>" title="<?=$file->name?>" disabled></iframe>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <p class="card-text">
                            Caminho: <?= $file->path ? $file->path : 'Voltar ao início' ?>
                        </p>

                        <p class="card-text">
                            Tamanho: <?= $file->size ?>
                        </p>
                        <?php if ($file->encodedPath && $file->subpath != '..') : ?>
                            <span class="btn btn-success" name="downloadFile" path="<?= $file->encodedPath ?>">Download</span>
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
        const uri = path ? `/navigate?path=${path}`: '/navigate'
        window.location.href = uri
    }
    document.querySelectorAll('[name="access"]').forEach(e => e.addEventListener('click', (e) => navegar(e.target)))

    downloadFile = (target) => {
        const path = target.getAttribute('path')
        const uri = `/file/download?path=${path}`
        window.open(uri, '_blank').focus();
    }
    document.querySelectorAll('[name="downloadFile"]').forEach(e => e.addEventListener('click', (e) => downloadFile(e.target)))

    previsualizar = (target) => {
        let path = target.getAttribute('path')
        const uri = `/file/preview?path=${path}`
        window.open(uri, '_blank').focus();
    }
    document.querySelectorAll('[name="preview"]').forEach(e => e.addEventListener('click', (e) => previsualizar(e.target)))
</script>
