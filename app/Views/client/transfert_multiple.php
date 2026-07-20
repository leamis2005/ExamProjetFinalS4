<?= $this->extend('layout') ?>

<?= $this->section('sidebar') ?>
<?= view('client/sidebar', ['active' => 'transfert']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $client = $client ?? []; ?>

<h1 class="mb-4">Envoi multiple</h1>

<p class="text-muted">Compte : <strong><?= esc($client['telephone']) ?></strong> — Solde actuel : <strong><?= number_format((float) $client['solde'], 2, ',', ' ') ?> Ar</strong></p>

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

<form method="post" action="<?= site_url('client/transfert-multiple/effectuer') ?>" class="w-75">
    <div class="mb-3">
        <label for="telephones" class="form-label">Numéros de téléphone des destinataires</label>
        <textarea class="form-control" id="telephones" name="telephones" rows="6" placeholder="0341234567&#10;0387654321&#10;0331111111" required><?= old('telephones') ?></textarea>
        <div class="form-text">Un numéro par ligne ou séparés par des virgules. Tous les destinataires doivent appartenir au même opérateur.</div>
    </div>
    <div class="mb-3">
        <label for="montant" class="form-label">Montant total à envoyer</label>
        <input type="number" step="0.01" min="100" class="form-control" id="montant" name="montant" value="<?= old('montant') ?>" required>
        <div class="form-text">Le montant sera réparti équitablement entre chaque destinataire.</div>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="inclure_frais_retrait" name="inclure_frais_retrait" value="1" <?= old('inclure_frais_retrait') ? 'checked' : '' ?>>
        <label class="form-check-label" for="inclure_frais_retrait">Inclure les frais de retrait</label>
    </div>
    <button type="submit" class="btn btn-primary">Effectuer l'envoi multiple</button>
    <a href="<?= site_url('client/transfert') ?>" class="btn btn-secondary">Retour</a>
</form>

<?php if (old('telephones') || old('montant')): ?>
    <div class="mt-4">
        <h5>Récapitulatif estimé</h5>
        <?php
            $telephones = array_filter(array_map('trim', preg_split('/[\r\n,]+/', old('telephones'))), fn($t) => $t !== '');
            $montantTotal = (float) (old('montant') ?? 0);
            $nombre = count($telephones);
            $part = $nombre > 0 ? $montantTotal / $nombre : 0;
            $fraisT = $part > 0 ? max(50, round($part * 0.01, 2)) : 0;
            $fraisR = old('inclure_frais_retrait') ? $fraisT : 0;
            $totalEstime = ($part + $fraisT + $fraisR) * $nombre;
        ?>
        <p>Destinataires : <strong><?= $nombre ?></strong></p>
        <p>Montant par destinataire : <strong><?= number_format($part, 2, ',', ' ') ?> Ar</strong></p>
        <p>Frais de transfert par destinataire : <strong><?= number_format($fraisT, 2, ',', ' ') ?> Ar</strong></p>
        <?php if ($fraisR > 0): ?>
            <p>Frais de retrait par destinataire : <strong><?= number_format($fraisR, 2, ',', ' ') ?> Ar</strong></p>
        <?php endif; ?>
        <p>Total estimé : <strong><?= number_format($totalEstime, 2, ',', ' ') ?> Ar</strong></p>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
