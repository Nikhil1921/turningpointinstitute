<?= form_open_multipart("$url/upload/$id") ?>
<?= form_label('<i class="fa fa-upload" ></i>Upload Ebook', 'ebook', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
<?= form_input([
'style' => "display: none;",
'type' => "file",
'id' => "ebook",
'name' => "ebook",
'onchange' => "bulkUpload(this.form)"
]) ?>
<?= form_close() ?>