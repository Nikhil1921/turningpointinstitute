<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title"><?= $title ?></h5>
		</div>
		<div class="card-body">
			<?= form_open_multipart("$url/upload-video/$id", '', ['video' => $data['video']]) ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= form_label('<i class="fa fa-video-camera" ></i>Select Video to upload', 'video', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block col-md-4']) ?>
                        <?= form_input([
                        'style' => "display: none;",
                        'type' => "file",
                        'id' => "video",
                        'name' => "video",
                        'onchange' => 'uploadIntroVideo(this.form)',
                        ]) ?>
                    </div>
                    <!-- Progress bar -->
					<div class="progress" style="display: none">
						<div class="progress-bar"></div>
					</div>
                    <br />
                </div>
                <?php if($data['video']): ?>
                <div class="col-md-6 mb-4">
                    <video src="<?= base_url('uploads/module_video/'.$data['video']) ?>" autoplay height="150" muted></video>
				</div>
                <?php endif ?>
                <div class="col-md-12">
                    <?= anchor($url, 'Go back', ['class' => 'btn btn-outline-primary btn-round col-md-3']) ?>
                    <?= anchor("$url/upload-assignments/$id", 'Upload assignments', ['class' => 'btn btn-outline-primary btn-round col-md-3']) ?>
                </div>
            </div>
            <?= form_close() ?>
		</div>
	</div>
</div>