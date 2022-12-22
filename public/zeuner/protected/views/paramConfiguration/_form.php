<?php
/* @var $this ParamConfigurationController */
/* @var $model ParamConfiguration */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'param-configuration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Eingabefelder mit <span class="required">*</span> werden ben&ouml;tigt.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'systemEmail'); ?>
		<?php echo $form->textField($model,'systemEmail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'systemEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adminEmail'); ?>
		<?php echo $form->textField($model,'adminEmail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'adminEmail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'minimumPrice'); ?>
		<?php echo $form->textField($model,'minimumPrice',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'minimumPrice'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'maximumPrice'); ?>
		<?php echo $form->textField($model,'maximumPrice',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'maximumPrice'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Hinzufuegen' : 'Speichern'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
