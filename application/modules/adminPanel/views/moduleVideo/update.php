<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open_multipart("$url/update/$id", '', ['video' => $data['video']]) ?>
<?= $contents ?>