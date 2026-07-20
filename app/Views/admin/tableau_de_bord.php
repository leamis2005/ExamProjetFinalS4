<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'dashboard']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$gainTotal = $gainTotal ?? 0;
$clientsCount = $clientsCount ?? 0;
$operationsRecentes = $operationsRecentes ?? [];
$situationClients = $situationClients ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Tableau de bord opérateur</h1>
    <a href="<?= site_url('admin/clients') ?>" class="btn btn-outline-secondary">Clients</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Gains cumulés</h6>
                <h3><?= number_format((float) $gainTotal, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Comptes clients</h6>
                <h3><?= (int) $clientsCount ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Opérations récentes</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Frais</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($operationsRecentes)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Aucune opération.</td></tr>
                    <?php else: ?>
                        <?php foreach ($operationsRecentes as $operation): ?>
                            <tr>
                                <td><?= esc($operation['date_operation']) ?></td>
                                <td><?= esc($operation['type_operation_nom'] ?? '') ?></td>
                                <td><?= number_format((float) $operation['montant'], 2, ',', ' ') ?> Ar</td>
                                <td><?= number_format((float) $operation['frais'], 2, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Situation des comptes clients</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                    <tr>
                        <th>Téléphone</th>
                        <th class="text-end">Solde</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($situationClients)): ?>
                        <tr><td colspan="2" class="text-center text-muted">Aucun client.</td></tr>
                    <?php else: ?>
                        <?php foreach ($situationClients as $client): ?>
                            <tr>
                                <td><?= esc($client['telephone']) ?></td>
                                <td class="text-end"><?= number_format((float) $client['solde'], 2, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>