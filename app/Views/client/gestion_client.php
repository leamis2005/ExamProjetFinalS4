<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'clients']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Gestion des comptes clients</h1>

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
                        <a href="<?= site_url('admin/clients/edit/' . $c['id']) ?>" class="btn btn-sm btn-warning me-1">Modifier</a>
                        <a href="<?= site_url('admin/clients/edit/' . $c['id']) ?>" class="btn btn-sm btn-warning me-1">Modifier</a>
                        <form action="<?= site_url('admin/clients/delete/' . $c['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce client ?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                        <a href="<?= site_url('admin/clients/historique/' . $c['id']) ?>" class="btn btn-sm btn-info text-white">Historique</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
