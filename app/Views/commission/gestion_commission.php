<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'commission']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Gestion des commissions</h1>

<div class="alert alert-info">
    <strong>Note :</strong> Cette commission s'applique uniquement lors des transferts vers un numéro appartenant à un autre opérateur.
</div>

<?php if (session()->get('message')): ?>
    <div class="alert alert-success">
        <?= session()->get('message') ?>
    </div>
<?php endif; ?>

<?php if (session()->get('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->get('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card" style="max-width: 800px;">
    <div class="card-body">
        <form method="post" action="<?= site_url('admin/commission/update') ?>">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Opérateur</th>
                            <th style="width: 250px;">Commission (%)</th>
                            <th>Valeur actuelle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($operateurs as $operateur): ?>
                            <tr>
                                <td><?= esc($operateur['nom']) ?></td>
                                <td>
                                    <input type="number" step="0.1" min="0" max="100" class="form-control"
                                           name="commission_<?= esc($operateur['id']) ?>"
                                           value="<?= esc(old('commission_' . $operateur['id'], $operateur['commission'])) ?>" required>
                                </td>
                                <td>
                                    <strong><?= esc($operateur['commission']) ?>%</strong> du montant transféré.
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
            <a href="<?= site_url('admin/tableau-de-bord') ?>" class="btn btn-secondary mt-3">Annuler</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
