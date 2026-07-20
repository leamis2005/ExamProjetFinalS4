<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1>Gestion des préfixes</h1>

<a href="<?= site_url('admin/prefixes/ajouter') ?>" class="btn btn-primary mb-3">Ajouter un préfixe</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Préfixe</th>
            <th>Opérateur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($prefixes)): ?>
            <tr><td colspan="4" class="text-center">Aucun préfixe enregistré.</td></tr>
        <?php else: ?>
            <?php foreach($prefixes as $p): ?>
                <tr>
                    <td><?= esc($p['id']) ?></td>
                    <td><?= esc($p['prefixe']) ?></td>
                    <td><?= esc($p['operateur_nom'] ?? $p['operateur_id']) ?></td>
                    <td>
                        <a href="<?= site_url('admin/prefixes/modifier/' . $p['id']) ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="<?= site_url('admin/prefixes/supprimer/' . $p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce préfixe ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
