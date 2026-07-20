<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'clients']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$client = $client ?? [];
$operations = $operations ?? [];
?>

<h1 class="mb-4">Historique des opérations</h1>

<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Client : <strong><?= esc($client['telephone'] ?? '-') ?></strong></p>
    <a href="<?= site_url('admin/clients') ?>" class="btn btn-secondary">Retour à la liste</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Date</th>
        <th>Type</th>
        <th>Expéditeur</th>
        <th>Récepteur</th>
        <th>Montant</th>
        <th>Frais</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($operations)): ?>
        <tr>
            <td colspan="6" class="text-center">Ce client n'a effectué aucune opération.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($operations as $operation): ?>
            <tr>
                <td><?= esc($operation['date_operation']) ?></td>
                <td><?= esc($operation['type_operation_nom'] ?? '') ?></td>
                <td><?= esc($operation['expediteur_telephone'] ?? '-') ?></td>
                <td><?= esc($operation['recepteur_telephone'] ?? '-') ?></td>
                <td><?= number_format((float) $operation['montant'], 2, ',', ' ') ?> Ar</td>
                <td><?= number_format((float) $operation['frais'], 2, ',', ' ') ?> Ar</td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
