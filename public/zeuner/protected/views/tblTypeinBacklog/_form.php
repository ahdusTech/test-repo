<?php
/* @var $this TblTypeinBacklogController */
/* @var $model TblTypeinBacklog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbl-typein-backlog-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'aggregated_on'); ?>
		<?php echo $form->textField($model,'aggregated_on'); ?>
		<?php echo $form->error($model,'aggregated_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog0'); ?>
		<?php echo $form->textField($model,'backlog0'); ?>
		<?php echo $form->error($model,'backlog0'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog1'); ?>
		<?php echo $form->textField($model,'backlog1'); ?>
		<?php echo $form->error($model,'backlog1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog2'); ?>
		<?php echo $form->textField($model,'backlog2'); ?>
		<?php echo $form->error($model,'backlog2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog3'); ?>
		<?php echo $form->textField($model,'backlog3'); ?>
		<?php echo $form->error($model,'backlog3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog4'); ?>
		<?php echo $form->textField($model,'backlog4'); ?>
		<?php echo $form->error($model,'backlog4'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog5'); ?>
		<?php echo $form->textField($model,'backlog5'); ?>
		<?php echo $form->error($model,'backlog5'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog6'); ?>
		<?php echo $form->textField($model,'backlog6'); ?>
		<?php echo $form->error($model,'backlog6'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog7'); ?>
		<?php echo $form->textField($model,'backlog7'); ?>
		<?php echo $form->error($model,'backlog7'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog8'); ?>
		<?php echo $form->textField($model,'backlog8'); ?>
		<?php echo $form->error($model,'backlog8'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'backlog9'); ?>
		<?php echo $form->textField($model,'backlog9'); ?>
		<?php echo $form->error($model,'backlog9'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->