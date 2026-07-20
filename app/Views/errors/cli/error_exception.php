<?php

/** @var Throwable $exception */
?>

Exception: <?= esc($exception->getMessage()) ?>

In <?= esc($exception->getFile()) ?> on line <?= esc((string) $exception->getLine()) ?>

<?php if (ENVIRONMENT !== 'production') : ?>

<?php foreach ($exception->getTrace() as $index => $trace) : ?>
<?= $index + 1 ?> <?= esc($trace['file'] ?? '[internal function]') ?>
    <?php if (isset($trace['line'])) : ?>
 on line <?= esc((string) $trace['line']) ?>
    <?php endif ?>

<?php endforeach ?>
<?php endif ?>