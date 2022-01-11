<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Question Gujarati', 'question') ?>
			<?= form_input('question', isset($data['question']) ? $data['question'] : '', 'class="form-control Gujarati-class" id="question"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Question Hindi', 'question_hindi') ?>
			<?= form_input('question_hindi', isset($data['question_hindi']) ? $data['question_hindi'] : '', 'class="form-control hindi-class" id="question"') ?>
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