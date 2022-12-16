<?php
/* @var $this TblSaleController */
/* @var $model TblSale */
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
		<?php echo $form->label($model,'domain'); ?>
		<?php echo $form->textField($model,'domain'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer'); ?>
		<?php echo $form->textField($model,'buyer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sold_at'); ?>
		<?php echo $form->textField($model,'sold_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paid'); ?>
		<?php echo $form->textField($model,'paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
