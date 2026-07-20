<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('client/sidebar', ['active' => 'retrait']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $client = $client ?? []; ?>

<h1 class="mb-4">Retrait</h1>

<p class="text-muted">Compte : <strong><?= esc($client['telephone']) ?></strong> — Solde actuel : <strong><?= number_format((float) $client['solde'], 2, ',', ' ') ?> Ar</strong></p>

<form method="post" action="<?= site_url('client/retrait/effectuer') ?>" class="w-50">
    <div class="mb-3">
        <label for="montant" class="form-label">Montant à retirer</label>
        <input type="number" step="0.01" min="100" class="form-control" id="montant" name="montant" value="<?= old('montant') ?>" required>
        <div class="form-text">Le montant minimum est de 100 Ar.</div>
    </div>
    <button type="submit" class="btn btn-warning">Effectuer le retrait</button>
</form>

<?= $this->endSection() ?>
