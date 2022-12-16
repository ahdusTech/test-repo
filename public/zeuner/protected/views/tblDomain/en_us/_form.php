<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbl-domain-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_tab_enabled'); ?>
		<?php echo $form->dropDownList($model,'contact_tab_enabled',array(''=>'Bitte auswaehlen',0=>'no',1=>'yes')); ?>
		<?php echo $form->error($model,'contact_tab_enabled'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'information_tab_enabled'); ?>
		<?php echo $form->dropDownList($model,'information_tab_enabled',array(''=>'Bitte auswaehlen',0=>'no',1=>'yes')); ?>
		<?php echo $form->error($model,'information_tab_enabled'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cpc_override'); ?>
		<?php echo $form->textField($model,'cpc_override'); ?>
		<?php echo $form->error($model,'cpc_override'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Hinzufuegen' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
