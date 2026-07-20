<h1><?= esc($titre ?? 'Préfixe') ?></h1>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
<?php endif; ?>

<?php if (isset($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php
    $id       = $prefixe['id'] ?? null;
    $action   = $id ? site_url('admin/prefixes/modifier/' . $id) : site_url('admin/prefixes/ajouter');
    $prefixeVal = $prefixe['prefixe'] ?? '';
    $operateurSelected = $prefixe['operateur_id'] ?? null;
?>

<?= form_open($action) ?>

    <div class="form-group">
        <label for="prefixe">Préfixe</label>
        <input type="text" class="form-control" name="prefixe" id="prefixe"
               value="<?= esc(old('prefixe', $prefixeVal)) ?>" required>
    </div>

    <div class="form-group">
        <label for="operateur_id">Opérateur</label>
        <select class="form-control" name="operateur_id" id="operateur_id" required>
            <option value="">-- Choisir un opérateur --</option>
            <?php foreach ($operateurs as $op): ?>
                <option value="<?= esc($op->id) ?>"
                    <?= (old('operateur_id', $operateurSelected) == $op->id) ? 'selected' : '' ?>>
                    <?= esc($op->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        <?= $id ? 'Enregistrer les modifications' : 'Ajouter' ?>
    </button>
    <a href="<?= site_url('admin/prefixes') ?>" class="btn btn-secondary">Annuler</a>

<?= form_close() ?>
