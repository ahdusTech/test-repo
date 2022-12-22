<?php
/* @var $this TblTypeinBacklogController */
/* @var $model TblTypeinBacklog */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'domain'); ?>
		<?php echo $form->textField($model,'domain'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'aggregated_on'); ?>
		<?php echo $form->textField($model,'aggregated_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog0'); ?>
		<?php echo $form->textField($model,'backlog0'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog1'); ?>
		<?php echo $form->textField($model,'backlog1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog2'); ?>
		<?php echo $form->textField($model,'backlog2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog3'); ?>
		<?php echo $form->textField($model,'backlog3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog4'); ?>
		<?php echo $form->textField($model,'backlog4'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog5'); ?>
		<?php echo $form->textField($model,'backlog5'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog6'); ?>
		<?php echo $form->textField($model,'backlog6'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog7'); ?>
		<?php echo $form->textField($model,'backlog7'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog8'); ?>
		<?php echo $form->textField($model,'backlog8'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backlog9'); ?>
		<?php echo $form->textField($model,'backlog9'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->