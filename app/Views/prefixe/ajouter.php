<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1><?= esc($titre) ?></h1>

<form method="post" action="<?= isset($prefixe)
    ? site_url('admin/prefixes/update/' . $prefixe['id'])
    : site_url('admin/prefixes/store') ?>" class="w-50">
    <div class="mb-3">
        <label for="prefixe" class="form-label">Préfixe</label>
        <input type="text" class="form-control" id="prefixe" name="prefixe"
               value="<?= esc($prefixe['prefixe'] ?? old('prefixe')) ?>" required>
        <div class="form-text">Ex : 032, 033, 034...</div>
    </div>
    <div class="mb-3">
        <label for="operateur_id" class="form-label">Opérateur</label>
        <select class="form-select" id="operateur_id" name="operateur_id" required>
            <option value="">-- Choisir un opérateur --</option>
            <?php foreach ($operateurs as $op): ?>
                <option value="<?= esc($op->id) ?>" <?= isset($prefixe) && $prefixe['operateur_id'] == $op->id ? 'selected' : '' ?>>
                    <?= esc($op->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="<?= site_url('admin/prefixes') ?>" class="btn btn-secondary">Retour</a>
</form>

<?= $this->endSection() ?>
