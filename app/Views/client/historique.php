<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php
$client = $client ?? [];
$operations = $operations ?? [];
?>

<h1>Historique des opérations</h1>

<p><strong>Compte :</strong> <?= esc($client['telephone']) ?></p>

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
            <td colspan="6" class="text-center">Aucune opération enregistrée.</td>
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

<a href="<?= site_url('client/dashboard') ?>" class="btn btn-secondary">Retour</a>

<?= $this->endSection() ?>