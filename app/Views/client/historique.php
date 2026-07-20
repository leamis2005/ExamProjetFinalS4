<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('client/sidebar', ['active' => 'historique']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$client = $client ?? [];
$operations = $operations ?? [];
?>

<h1 class="mb-4">Historique des opérations</h1>

<p class="text-muted">Compte : <strong><?= esc($client['telephone']) ?></strong></p>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Date</th>
        <th>Type</th>
        <th>Expéditeur</th>
        <th>Récepteur</th>
        <th>Montant</th>
        <th>Frais transfert</th>
        <th>Frais retrait</th>
        <th>Total reçu</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($operations)): ?>
        <tr>
            <td colspan="8" class="text-center">Aucune opération enregistrée.</td>
        </tr>
    <?php else: ?>
            <?php foreach ($operations as $operation): ?>
                <tr>
                    <td><?= esc($operation['date_operation']) ?></td>
                    <td><?= esc($operation['type_operation_nom'] ?? '') ?></td>
                    <td><?= esc($operation['expediteur_telephone'] ?? '-') ?></td>
                    <td><?= esc($operation['recepteur_telephone'] ?? '-') ?></td>
                    <td class="text-success fw-semibold"><?= number_format((float) $operation['montant'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format((float) $operation['frais'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format((float) ($operation['frais_retrait'] ?? 0), 2, ',', ' ') ?> Ar</td>
                    <td class="text-primary fw-semibold"><?= number_format((float) ($operation['montant'] + ($operation['frais_retrait'] ?? 0)), 2, ',', ' ') ?> Ar</td>
                </tr>
            <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
