<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1>Gestion des comptes clients</h1>

<a href="<?= site_url('admin/clients/create') ?>" class="btn btn-primary mb-3">Nouveau client</a>
<a href="<?= site_url('admin/prefixes') ?>" class="btn btn-outline-secondary mb-3">Préfixes</a>
<a href="<?= site_url('logout') ?>" class="btn btn-outline-danger mb-3 float-end">Déconnexion</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Téléphone</th>
            <th>Solde</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($clients)): ?>
            <tr><td colspan="4" class="text-center">Aucun client enregistré.</td></tr>
        <?php else: ?>
            <?php foreach ($clients as $c): ?>
                <tr>
                    <td><?= esc($c['id']) ?></td>
                    <td><?= esc($c['telephone']) ?></td>
                    <td><?= number_format((float)$c['solde'], 2, ',', ' ') ?></td>
                    <td>
                        <a href="<?= site_url('admin/clients/edit/' . $c['id']) ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="<?= site_url('admin/clients/delete/' . $c['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce client ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
