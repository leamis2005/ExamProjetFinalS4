<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'situation']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Montants à reverser aux opérateurs</h1>

<div class="alert alert-warning">
    <strong>Note :</strong> Cette page affiche le montant total à reverser à chaque opérateur à partir des commissions inter-opérateurs.
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Opérateur</th>
                    <th>Montant à reverser</th>
                    <th>Nombre de transferts</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reversAuxOperateurs)): ?>
                    <tr><td colspan="3" class="text-center">Aucun transfert inter-opérateur enregistré.</td></tr>
                <?php else: ?>
                    <?php foreach ($reversAuxOperateurs as $row): ?>
                        <tr>
                            <td><?= esc($row['operateur_nom']) ?></td>
                            <td class="text-warning fw-semibold"><?= number_format((float) $row['montant_a_reverser'], 2, ',', ' ') ?> Ar</td>
                            <td><?= (int) $row['nombre_transferts'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
