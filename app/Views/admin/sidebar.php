<?php
$active = $active ?? '';
?>
<aside class="sidebar">
    <div class="brand">
        <div class="logo">M</div>
        <span>Mobile Money</span>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link <?= $active === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('admin/tableau-de-bord') ?>">
            <span class="ico">📊</span> Tableau de bord
        </a>
        <a class="nav-link <?= $active === 'clients' ? 'active' : '' ?>" href="<?= site_url('admin/clients') ?>">
            <span class="ico">👥</span> Clients
        </a>
        <a class="nav-link <?= $active === 'prefixes' ? 'active' : '' ?>" href="<?= site_url('admin/prefixes') ?>">
            <span class="ico">📱</span> Préfixes
        </a>
        <a class="nav-link logout" href="<?= site_url('logout') ?>">
            <span class="ico">🚪</span> Déconnexion
        </a>
    </nav>
</aside>
