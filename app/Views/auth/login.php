<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="auth-card">
    <div class="brand">
        <h1>Connexion</h1>
        <p>Accédez à votre espace Mobile Money</p>
    </div>

    <form method="post" action="<?= site_url('login/attempt') ?>">
        <div class="mb-3">
            <label for="telephone" class="form-label">Numéro de téléphone</label>
            <div class="form-text">Admin: 0000000000</div>
            <input type="text" class="form-control" id="telephone" name="telephone"
                   placeholder="Ex : 03********" value="<?= old('telephone') ?>" required>
            <div class="form-text">Saisissez votre numéro pour une connexion automatique.</div>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<?= $this->endSection() ?>
