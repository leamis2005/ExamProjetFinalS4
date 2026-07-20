<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('client/sidebar', ['active' => 'transfert']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $client = $client ?? []; ?>

<h1 class="mb-4">Transfert</h1>

<p class="text-muted">Compte : <strong><?= esc($client['telephone']) ?></strong> — Solde actuel : <strong><?= number_format((float) $client['solde'], 2, ',', ' ') ?> Ar</strong></p>

<form method="post" action="<?= site_url('client/transfert/effectuer') ?>" class="w-50">
    <div class="mb-3">
        <label for="telephone_recepteur" class="form-label">Téléphone du destinataire</label>
        <input type="text" class="form-control" id="telephone_recepteur" name="telephone_recepteur" value="<?= old('telephone_recepteur') ?>" required>
    </div>
    <div class="mb-3">
        <label for="montant" class="form-label">Montant à transférer</label>
        <input type="number" step="0.01" min="100" class="form-control" id="montant" name="montant" value="<?= old('montant') ?>" required>
        <div class="form-text">Le montant minimum est de 100 Ar.</div>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="inclure_frais_retrait" name="inclure_frais_retrait" value="1">
        <label class="form-check-label" for="inclure_frais_retrait">Inclure les frais de retrait</label>
    </div>
    <button type="submit" class="btn btn-primary">Effectuer le transfert</button>
</form>

<?= $this->endSection() ?>
