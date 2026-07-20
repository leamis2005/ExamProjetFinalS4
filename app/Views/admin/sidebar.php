<?php
$active = $active ?? '';
?>
<aside class="sidebar">
    <div class="brand">
        <span>Mobile Money</span>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link <?= $active === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('admin/tableau-de-bord') ?>">
            Tableau de bord
        </a>
        <a class="nav-link <?= $active === 'clients' ? 'active' : '' ?>" href="<?= site_url('admin/clients') ?>">
            Clients
        </a>
        <a class="nav-link <?= $active === 'prefixes' ? 'active' : '' ?>" href="<?= site_url('admin/prefixes') ?>">
            Préfixes
        </a>
        <a class="nav-link <?= $active === 'commission' ? 'active' : '' ?>" href="<?= site_url('admin/commission') ?>">
            Commissions
        </a>
        <a class="nav-link <?= $active === 'situation' ? 'active' : '' ?>" href="<?= site_url('admin/situation') ?>">
            Montants à reverser
        </a>
        <a class="nav-link logout" href="<?= site_url('logout') ?>">
            Déconnexion
        </a>
    </nav>
</aside>
