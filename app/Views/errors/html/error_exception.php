<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Application Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: sans-serif; margin: 2rem; color: #222; }
        pre { background: #f5f5f5; padding: 1rem; overflow: auto; }
    </style>
</head>
<body>
    <h1>Application Error</h1>
    <p><?= esc($exception->getMessage()) ?></p>
    <pre><?= esc($exception->getFile()) ?>:<?= esc((string) $exception->getLine()) ?></pre>
</body>
</html>