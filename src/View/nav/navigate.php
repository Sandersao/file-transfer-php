<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h3>Pastas</h3>
        </div>
    </div>
    <div class="row">
        <?php foreach ($folderList as $folder) : ?>
            <div class="col-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $folder->path ? $folder->subpath : 'Início' ?></h5>
                        <p class="card-text"><?= $folder->path ? $folder->path : 'Voltar ao início' ?></p>

                        <?php if ($folder->subpath == '..') : ?>
                            <div class="btn btn-info" name="access" path="<?= $folder->path ?>">Voltar</div>
                        <?php endif; ?>

                        <?php if ($folder->subpath != '..') : ?>
                            <div class="btn btn-primary" name="access" path="<?= $folder->path ?>">Acessar</div>
                        <?php endif; ?>

                        <?php if ($folder->path && $folder->subpath != '..') : ?>
                            <span class="btn btn-success" name="download" path="<?= $folder->path ?>">Download</span>
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
        <?php foreach ($fileList as $file) : ?>
            <div class="col-3 overflow-auto">
                <div class="card">
                    <div class="card-body">
                        <?php if ($file->isPreviewable) : ?>
                            <div class="card-img-top btn" name="preview" path="<?= $file->path ?>">
                                <img src="..." alt="Preview">
                            </div>
                        <?php endif; ?>
                        <h5 class="card-title"><?= $file->path ? $file->subpath : 'Início' ?></h5>
                        <p class="card-text"><?= $file->path ? $file->path : 'Voltar ao início' ?></p>
                        <?php if ($file->subpath == '..') : ?>
                            <div class="btn btn-info" name="access" path="<?= $file->path ?>">Voltar</div>
                        <?php endif; ?>

                        <?php if ($file->path && $file->subpath != '..') : ?>
                            <span class="btn btn-success" name="download" path="<?= $file->path ?>">Download</span>
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
        window.location.href = `/navigate?path=${path}`
    }
    document.querySelectorAll('[name="access"]').forEach(e => e.addEventListener('click', (e) => navegar(e.target)))
</script>
