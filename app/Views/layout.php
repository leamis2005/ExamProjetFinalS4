<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Mobile Money') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Mobile Money</span>
        <div>
            <a href="<?= site_url('admin/clients') ?>" class="btn btn-outline-light btn-sm">Clients</a>
            <a href="<?= site_url('admin/prefixes') ?>" class="btn btn-outline-light btn-sm">Préfixes</a>
            <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm">Déconnexion</a>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
</div>
</body>
</html>
