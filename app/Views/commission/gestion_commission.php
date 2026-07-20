<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'commission']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Gestion des commissions</h1>

<div class="alert alert-info">
    <strong>Note :</strong> Cette commission s'applique uniquement lors des transferts vers un numéro appartenant à un autre opérateur.
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form method="post" action="<?= site_url('admin/commission/update') ?>">
            <div class="mb-3">
                <label for="commission" class="form-label">Pourcentage de commission (%)</label>
                <input type="number" step="0.1" min="0" max="100" class="form-control"
                       id="commission" name="commission" value="<?= esc($commission) ?>" required>
                <div class="form-text">
                    Valeur actuelle : <strong><?= esc($commission) ?>%</strong> du montant transféré.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="<?= site_url('admin/tableau-de-bord') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
