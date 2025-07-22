<div class="container-fluid">
    <div class="row">
        <?php foreach ($pathList as $path) : ?>
                <div class="card col-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $path->path ? $path->subpath : 'Início' ?></h5>
                        <p class="card-text"><?= $path->path ? $path->path : 'Voltar ao início' ?></p>
                        <?php if ($path->subpath == '..') : ?>
                            <div class="btn btn-info" name="access" path="<?= $path->path ?>">Voltar</div>
                        <?php endif; ?>
                        <?php if ($path->subpath != '..' && !$path->isFile) : ?>
                            <div class="btn btn-primary" name="access" path="<?= $path->path ?>">Acessar</div>
                        <?php endif; ?>

                        <?php if ($path->isFile) : ?>
                            <div class="btn btn-warning" name="preview" path="<?= $path->path ?>">Visualizar</div>
                        <?php endif; ?>
                        
                        <?php if ($path->path && $path->subpath != '..') : ?>
                            <span class="btn btn-success" name="download" path="<?= $path->path ?>">Download</span>
                        <?php endif; ?>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    navegar = (target) => {
        console.log(target);

        path = target.getAttribute('path')
        window.location.href = `/path?path=${path}`
    }
    document.querySelectorAll('[name="access"]').forEach(e => e.addEventListener('click', (e) => navegar(e.target)))
</script>