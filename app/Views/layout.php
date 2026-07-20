<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Mobile Money') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
<?php $hasSidebar = $this->renderSection('sidebar', true); ?>
<?php if ($hasSidebar): ?>
<div class="app-layout">
    <?= $hasSidebar ?>

    <main class="content-area">
<?php else: ?>
<main class="auth-page">
<?php endif; ?>
        <?php if (session()->getFlashdata('bienvenue')): ?>
            <div class="alert alert-info"><?= esc(session()->getFlashdata('bienvenue')) ?></div>
        <?php endif; ?>
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
        <div class="page-card">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
    <?php if ($hasSidebar): ?>
</div>
<?php endif; ?>
</body>
</html>
