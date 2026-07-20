<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php $client = $client ?? []; ?>

<h1>Tableau de bord client</h1>

<p><strong>Téléphone :</strong> <?= esc($client['telephone']) ?></p>
<p><strong>Solde :</strong> <?= number_format((float)$client['solde'], 2, ',', ' ') ?> Ar</p>

<a href="<?= site_url('client/depot') ?>" class="btn btn-success me-2">Faire un dépôt</a>
<a href="<?= site_url('client/retrait') ?>" class="btn btn-warning me-2">Faire un retrait</a>
<a href="<?= site_url('client/transfert') ?>" class="btn btn-primary me-2">Faire un transfert</a>
<a href="<?= site_url('client/historique') ?>" class="btn btn-info me-2">Voir l'historique</a>
<a href="<?= site_url('admin/clients') ?>" class="btn btn-secondary me-2">Retour</a>
<a href="<?= site_url('logout') ?>" class="btn btn-outline-danger">Déconnexion</a>

<?= $this->endSection() ?>
