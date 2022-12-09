<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auction'); ?>
		<?php echo $form->textField($model,'auction'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auction_begin'); ?>
		<?php echo $form->textField($model,'auction_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auction_start_price'); ?>
		<?php echo $form->textField($model,'auction_start_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auction_price_step'); ?>
		<?php echo $form->textField($model,'auction_price_step'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'initiator'); ?>
		<?php echo $form->textField($model,'initiator'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sold'); ?>
		<?php echo $form->textField($model,'sold'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
