<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/add") ?>
<?php foreach ($this->input->get() as $k => $v): ?>
    <?= form_hidden($k, $v) ?>
<?php endforeach ?>
<div class="row">
<?= $contents ?>