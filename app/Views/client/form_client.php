<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('admin/sidebar', ['active' => 'clients']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1><?= isset($client) ? 'Modifier le client' : 'Nouveau client' ?></h1>

<form method="post" action="<?= isset($client)
    ? site_url('admin/clients/update/' . $client['id'])
    : site_url('admin/clients/store') ?>" class="w-50">
    <div class="mb-3">
        <label for="telephone" class="form-label">Numéro de téléphone</label>
        <input type="text" class="form-control" id="telephone" name="telephone"
               value="<?= esc($client['telephone'] ?? old('telephone')) ?>" required>
    </div>
    <div class="mb-3">
        <label for="solde" class="form-label">Solde initial</label>
        <input type="number" step="0.01" min="0" class="form-control" id="solde" name="solde"
               value="<?= esc($client['solde'] ?? old('solde', 0)) ?>">
    </div>
    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="<?= site_url('admin/clients') ?>" class="btn btn-secondary">Annuler</a>
</form>

<?= $this->endSection() ?>
