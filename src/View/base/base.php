<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'No title' ?></title>

    <script src="/lib/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/lib/bootstrap.min.css">
    <style>
        [disabled] {
            pointer-events: none;
        }

        iframe {
            border: none;
        }
    </style>
</head>

<body>

    <?= $content ?>

</body>

</html>
