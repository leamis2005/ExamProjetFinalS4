<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'dashboard']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$gainTotal = $gainTotal ?? 0;
$commissionInterOperateur = $commissionInterOperateur ?? 0;
$clientsCount = $clientsCount ?? 0;
$operationsRecentes = $operationsRecentes ?? [];
$situationClients = $situationClients ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Tableau de bord opérateur</h1>
</div>

<div class="row g-3 mb-4 animate-fade-in">
    <div class="col-md-4">
        <div class="card card-accent green">
            <div class="card-body">
                <h6 class="text-muted">Gains cumulés</h6>
                <h3 class="mb-0"><?= number_format((float) $gainTotal, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-accent blue">
            <div class="card-body">
                <h6 class="text-muted">Comptes clients</h6>
                <h3 class="mb-0"><?= (int) $clientsCount ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-accent yellow">
            <div class="card-body">
                <h6 class="text-muted">Opérations enregistrées</h6>
                <h3 class="mb-0"><?= count($operationsRecentes) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4 animate-fade-in">
    <div class="col-md-4">
        <div class="card card-accent green">
            <div class="card-body">
                <h6 class="text-muted">Gains opérateur</h6>
                <h3 class="mb-0"><?= number_format((float) $gainTotal, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-accent blue">
            <div class="card-body">
                <h6 class="text-muted">Commissions inter-opérateurs</h6>
                <h3 class="mb-0"><?= number_format((float) $commissionInterOperateur, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-accent yellow">
            <div class="card-body">
                <h6 class="text-muted">Comptes clients</h6>
                <h3 class="mb-0"><?= (int) $clientsCount ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7 animate-fade-in">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 fw-semibold">Opérations récentes</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Frais</th>
                            <th>Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($operationsRecentes)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Aucune opération.</td></tr>
                    <?php else: ?>
                        <?php foreach ($operationsRecentes as $operation): ?>
                            <tr>
                                <td><?= esc($operation['date_operation']) ?></td>
                                <td>
                                    <?php
                                    $type = strtolower($operation['type_operation_nom'] ?? '');
                                    $badgeClass = 'bg-secondary';
                                    if (str_contains($type, 'dépôt') || str_contains($type, 'depot')) {
                                        $badgeClass = 'bg-success';
                                    } elseif (str_contains($type, 'retrait')) {
                                        $badgeClass = 'bg-danger';
                                    } elseif (str_contains($type, 'transfert')) {
                                        $badgeClass = 'bg-warning text-dark';
                                    }
                                    ?>
                                    <span class="badge <?= $badgeClass ?> badge-glow"><?= esc($operation['type_operation_nom'] ?? '') ?></span>
                                </td>
                                <td class="text-success fw-semibold"><?= number_format((float) $operation['montant'], 2, ',', ' ') ?> Ar</td>
                                <td class="text-danger"><?= number_format((float) $operation['frais'], 2, ',', ' ') ?> Ar</td>
                                <td class="text-warning fw-semibold"><?= number_format((float) ($operation['commission'] ?? 0), 2, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5 animate-fade-in">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 fw-semibold">Situation des comptes clients</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
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
                                <td class="text-end fw-semibold <?= (float)$client['solde'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format((float) $client['solde'], 2, ',', ' ') ?> Ar
                                </td>
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