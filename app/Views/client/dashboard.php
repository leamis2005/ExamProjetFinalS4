<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<h1>Tableau de bord client</h1>

<p><strong>Téléphone :</strong> <?= esc($client['telephone']) ?></p>
<p><strong>Solde :</strong> <?= number_format((float)$client['solde'], 2, ',', ' ') ?> Ar</p>

<a href="<?= site_url('client/depot') ?>" class="btn btn-success me-2">Faire un dépôt</a>
<a href="<?= site_url('admin/clients') ?>" class="btn btn-secondary">Retour</a>

<?= $this->endSection() ?>
