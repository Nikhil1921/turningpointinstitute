<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title">Add <?= $title ?></h5>
		</div>
		<div class="card-body">
			<?= form_open_multipart("$url/add"); ?>
            <?php $this->load->view("$url/form"); ?>
		</div>
	</div>
</div>