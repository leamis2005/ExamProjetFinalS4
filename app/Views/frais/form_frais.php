<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php $isEdit = ! empty($bareme); ?>

<h1 class="mb-3"><?= $isEdit ? 'Modifier le barème' : 'Ajouter un barème' ?></h1>

<form method="post" action="<?= $isEdit ? site_url('admin/frais/update/' . $bareme['id']) : site_url('admin/frais/store') ?>" class="w-75">
    <div class="mb-3">
        <label for="type_operation_id" class="form-label">Type d'opération</label>
        <select class="form-select" id="type_operation_id" name="type_operation_id" required>
            <option value="">Sélectionner</option>
            <?php foreach ($typeOperations as $typeOperation): ?>
                <option value="<?= esc($typeOperation['id']) ?>" <?= old('type_operation_id', $bareme['type_operation_id'] ?? '') == $typeOperation['id'] ? 'selected' : '' ?>>
                    <?= esc($typeOperation['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="montant_min" class="form-label">Montant minimum</label>
            <input type="number" step="0.01" min="0" class="form-control" id="montant_min" name="montant_min"
                   value="<?= old('montant_min', $bareme['montant_min'] ?? '') ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="montant_max" class="form-label">Montant maximum</label>
            <input type="number" step="0.01" min="0" class="form-control" id="montant_max" name="montant_max"
                   value="<?= old('montant_max', $bareme['montant_max'] ?? '') ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="frais" class="form-label">Frais</label>
            <input type="number" step="0.01" min="0" class="form-control" id="frais" name="frais"
                   value="<?= old('frais', $bareme['frais'] ?? '') ?>" required>
        </div>
    </div>

    <button type="submit" class="btn btn-success"><?= $isEdit ? 'Enregistrer' : 'Créer' ?></button>
    <a href="<?= site_url('admin/frais') ?>" class="btn btn-secondary">Retour</a>
</form>

<?= $this->endSection() ?>