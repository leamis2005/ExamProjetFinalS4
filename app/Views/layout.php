<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Mobile Money') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --accent: #2563eb;
        }
        body {
            background-color: #f1f5f9;
            min-height: 100vh;
        }
        .app-layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #e2e8f0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar .brand {
            padding: 1.5rem 1.25rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar .brand .logo {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .sidebar .nav {
            flex: 1;
            padding: 0.75rem 0;
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 3px solid transparent;
            transition: background-color 0.15s, color 0.15s;
        }
        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: var(--sidebar-hover);
            color: #fff;
            border-left-color: var(--accent);
        }
        .sidebar .nav-link .ico {
            width: 20px;
            text-align: center;
        }
        .sidebar .nav-link.logout {
            color: #fca5a5;
        }
        .sidebar .nav-link.logout:hover {
            background-color: #7f1d1d;
            color: #fff;
        }
        .sidebar .user-box {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .sidebar .user-box strong {
            color: #e2e8f0;
            display: block;
        }
        .content-area {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }
        .page-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: 0 1px 3px rgba(15,23,42,0.08);
        }
    </style>
</head>
<body>
<div class="app-layout">
    <?= $this->renderSection('sidebar') ?>

    <main class="content-area">
        <?php if (session()->getFlashdata('bienvenue')): ?>
            <div class="alert alert-info"><?= esc(session()->getFlashdata('bienvenue')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="page-card">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>
</body>
</html>
