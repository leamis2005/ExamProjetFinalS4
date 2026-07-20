<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Gestion des frais</h1>
    <a href="<?= site_url('admin/frais/create') ?>" class="btn btn-primary">Ajouter un barème</a>
</div>

<?php
$gainsInternes = $gainsInternes ?? 0;
$gainsInterOperateurs = $gainsInterOperateurs ?? 0;
$gainTotal = $gainTotal ?? 0;
?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-accent green">
            <div class="card-body">
                <h6 class="text-muted">Gains internes</h6>
                <h3 class="mb-0"><?= number_format((float) $gainsInternes, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-accent blue">
            <div class="card-body">
                <h6 class="text-muted">Gains des autres opérateurs</h6>
                <h3 class="mb-0"><?= number_format((float) $gainsInterOperateurs, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-accent yellow">
            <div class="card-body">
                <h6 class="text-muted">Total gains</h6>
                <h3 class="mb-0"><?= number_format((float) $gainTotal, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Répartition des gains</div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead>
            <tr>
                <th>Catégorie</th>
                <th class="text-end">Montant</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gains internes</td>
                    <td class="text-end"><?= number_format((float) $gainsInternes, 2, ',', ' ') ?> Ar</td>
                </tr>
                <tr>
                    <td>Gains provenant des autres opérateurs</td>
                    <td class="text-end"><?= number_format((float) $gainsInterOperateurs, 2, ',', ' ') ?> Ar</td>
                </tr>
                <tr class="table-light fw-semibold">
                    <td>Total</td>
                    <td class="text-end"><?= number_format((float) $gainTotal, 2, ',', ' ') ?> Ar</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">Barèmes de frais configurés</div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead>
            <tr>
                <th>Type d'opération</th>
                <th>Montant min</th>
                <th>Montant max</th>
                <th>Frais</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (! empty($baremes)): ?>
                <?php foreach ($baremes as $bareme): ?>
                    <tr>
                        <td><?= esc($bareme['type_operation_nom'] ?? 'Inconnu') ?></td>
                        <td><?= number_format((float) $bareme['montant_min'], 2, ',', ' ') ?> Ar</td>
                        <td><?= number_format((float) $bareme['montant_max'], 2, ',', ' ') ?> Ar</td>
                        <td><?= number_format((float) $bareme['frais'], 2, ',', ' ') ?> Ar</td>
                        <td class="text-end">
                            <a href="<?= site_url('admin/frais/edit/' . $bareme['id']) ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="<?= site_url('admin/frais/delete/' . $bareme['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce barème ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Aucun barème enregistré.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>