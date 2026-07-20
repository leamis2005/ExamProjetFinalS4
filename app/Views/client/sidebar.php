<?php
$active = $active ?? '';
$telephone = session()->get('client_telephone') ?? '';
?>
<aside class="sidebar">
    <div class="brand">
        <span>Mobile Money</span>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link <?= $active === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('client/dashboard') ?>">
            <span class="ico"></span> Tableau de bord
        </a>
        <a class="nav-link <?= $active === 'depot' ? 'active' : '' ?>" href="<?= site_url('client/depot') ?>">
            <span class="ico"></span> Dépôt
        </a>
        <a class="nav-link <?= $active === 'retrait' ? 'active' : '' ?>" href="<?= site_url('client/retrait') ?>">
            <span class="ico"></span> Retrait
        </a>
        <a class="nav-link <?= $active === 'transfert' ? 'active' : '' ?>" href="<?= site_url('client/transfert') ?>">
            <span class="ico"></span> Transfert
        </a>
        <a class="nav-link <?= $active === 'historique' ? 'active' : '' ?>" href="<?= site_url('client/historique') ?>">
            <span class="ico"></span> Historique
        </a>
        <a class="nav-link logout" href="<?= site_url('logout') ?>">
            <span class="ico"></span> Déconnexion
        </a>
    </nav>
    <div class="user-box">
        Connecté en tant que
        <strong><?= esc($telephone) ?></strong>
        Client
    </div>
</aside>
