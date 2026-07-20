<h1>Gestion des préfixes</h1>

<table class="table table-bordered">

<thead>
<tr>
    <th>ID</th>
    <th>Préfixe</th>
    <th>Opérateur</th>
</tr>
</thead>

<tbody>

<?php foreach($prefixes as $p): ?>

<tr>

<td>
<?= esc($p['id']) ?>
</td>

<td>
<?= esc($p['prefixe']) ?>
</td>

<td>
<?= esc($p['operateur_id']) ?>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>