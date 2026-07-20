<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('client/sidebar', ['active' => 'dashboard']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $client = $client ?? []; ?>

<h1 class="mb-4">Tableau de bord</h1>

<div class="row g-3">
    <div class="col-md-6">
        <div class="border rounded p-3 bg-light">
            <div class="text-muted small text-uppercase">Téléphone</div>
            <div class="fs-5 fw-semibold"><?= esc($client['telephone']) ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded p-3 bg-light">
            <div class="text-muted small text-uppercase">Solde</div>
            <div class="fs-5 fw-semibold"><?= number_format((float)$client['solde'], 2, ',', ' ') ?> Ar</div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
