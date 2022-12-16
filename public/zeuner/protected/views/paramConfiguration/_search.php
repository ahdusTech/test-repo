<?php
/* @var $this ParamConfigurationController */
/* @var $model ParamConfiguration */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'adminEmail'); ?>
		<?php echo $form->textField($model,'adminEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'systemEmail'); ?>
		<?php echo $form->textField($model,'systemEmail'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
