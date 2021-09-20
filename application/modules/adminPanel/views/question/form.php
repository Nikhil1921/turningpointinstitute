<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-6">
		<div class="form-group">
            <?= form_label('Module', 'module_id') ?>
			<select class="form-control" name="module_id" id="module_id" onchange="getModuleVideos(this)" data-dependent="video_id" data-value="<?= isset($data['video_id']) ? e_id($data['video_id']) : '' ?>">
                <option value="" selected disabled>Select module</option>
                <?php foreach($modules as $module): ?>
				<option value="<?= e_id($module['id']) ?>" <?= isset($data['module_id']) && $data['module_id'] == $module['id'] ? 'selected' : '' ?>><?= $module['title'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
    <div class="col-md-6">
		<div class="form-group">
            <?= form_label('Module video', 'video_id') ?>
			<select class="form-control" name="video_id" id="video_id"></select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Question', 'question') ?>
			<?= form_input('question', isset($data['question']) ? $data['question'] : '', 'class="form-control" id="question"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Answer', 'answer') ?>
			<?= form_input('answer', isset($data['answer']) ? $data['answer'] : '', 'class="form-control" id="answer"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Options', 'options') ?>
            <br>
			<?= form_input('options', isset($data['options']) ? $data['options'] : '', 'data-role="tagsinput" class="form-control" id="options"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Language', 'language') ?>
			<select class="form-control" name="language" id="language">
				<option value="Gujarati" <?= isset($data['language']) && $data['language'] == 'Gujarati' ? 'selected' : '' ?>>Gujarati</option>
				<option value="Hindi" <?= isset($data['language']) && $data['language'] == 'Hindi' ? 'selected' : '' ?>>Hindi</option>
			</select>
		</div>
	</div>
    <div class="col-md-6">
		<div class="form-group">
            <?= form_label('Test Type', 'test_type') ?>
			<select class="form-control" name="test_type" id="test_type">
				<option value="Blocks" <?= isset($data['test_type']) && $data['test_type'] == 'Blocks' ? 'selected' : '' ?>>Blocks</option>
				<option value="Speaking" <?= isset($data['test_type']) && $data['test_type'] == 'Speaking' ? 'selected' : '' ?>>Speaking</option>
				<option value="Writing" <?= isset($data['test_type']) && $data['test_type'] == 'Writing' ? 'selected' : '' ?>>Writing</option>
			</select>
		</div>
	</div>
</div>
<?= form_close() ?>
<script>
    var e = document.createEvent('HTMLEvents');
    e.initEvent('change', false, true);
    document.getElementById('module_id').dispatchEvent(e);
</script>
<script src="<?= b_asset('bootstrap-tagsinput/bootstrap-tagsinput.js') ?>"></script>