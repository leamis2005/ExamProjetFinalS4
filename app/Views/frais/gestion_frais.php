<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Gestion des frais</h1>
    <a href="<?= site_url('admin/frais/create') ?>" class="btn btn-primary">Ajouter un barème</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Gains générés par les frais</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <thead>
                    <tr>
                        <th>Type d'opération</th>
                        <th class="text-end">Gain total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (! empty($gains)): ?>
                        <?php foreach ($gains as $gain): ?>
                            <tr>
                                <td><?= esc($gain['type_operation_nom'] ?? 'Inconnu') ?></td>
                                <td class="text-end"><?= number_format((float) ($gain['gain_total'] ?? 0), 2, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">Aucune opération facturée pour le moment.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
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