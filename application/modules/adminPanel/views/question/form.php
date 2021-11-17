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
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Question', 'question') ?>
			<?= form_input('question', isset($data['question']) ? $data['question'] : '', 'class="form-control gujarati-class" id="question"') ?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?= form_button([ 'content' => 'Add Answer',
			'type'    => 'button',
			'onclick'    => 'addAnswer()',
			'class'   => 'btn btn-success btn-outline-success waves-effect btn-round btn-block']) ?>
		</div>
	</div>
	<div class="col-md-12" id="view-answer">
		<?php if (isset($data['answer'])): foreach(json_decode($data['answer']) as $a => $ans): ?>
			<div class="row" id="answer_<?= $a+1 ?>">
				<div class="col-md-10">
					<div class="form-group"> <input type="text" name="answer[]" value="<?= $ans ?>" class="form-control form-control-round" placeholder="Answer"></div>
				</div>
				<div class="col-md-2">
					<div class="form-group"> <button type="button" class="btn btn-danger btn-outline-danger waves-effect btn-round btn-block float-right" onclick="removeMenu('answer_<?= $a+1 ?>')">Remove</button></div>
				</div>
			</div>
		<?php endforeach; endif ?>
	</div>
</div>
<?= form_close() ?>
<script>
    var e = document.createEvent('HTMLEvents');
    e.initEvent('change', false, true);
    document.getElementById('module_id').dispatchEvent(e);
</script>