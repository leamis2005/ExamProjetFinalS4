<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'situation']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Situation des montants à envoyer aux opérateurs</h1>

<div class="alert alert-warning">
    <strong>Note :</strong> Cette page affiche les commissions générées par les transferts inter-opérateurs, qui doivent être reversées à chaque opérateur concerné.
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Opérateur</th>
                    <th>Nombre de transferts</th>
                    <th>Total commission</th>
                    <th>Montant à reverser</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transfertsInterOperateur)): ?>
                    <tr><td colspan="4" class="text-center">Aucun transfert inter-opérateur enregistré.</td></tr>
                <?php else: ?>
                    <?php foreach ($transfertsInterOperateur as $row): ?>
                        <tr>
                            <td><?= esc($row['operateur_nom']) ?></td>
                            <td><?= (int) $row['nombre_transferts'] ?></td>
                            <td class="text-success fw-semibold"><?= number_format((float) $row['total_commission'], 2, ',', ' ') ?> Ar</td>
                            <td class="text-warning fw-semibold"><?= number_format((float) $row['total_commission'], 2, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
