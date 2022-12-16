<?php
/* @var $this SmsGatewayConfigurationController */
/* @var $model SmsGatewayConfiguration */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sms-gateway-configuration-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Eingabefelder mit <span class="required">*</span> werden ben&ouml;tigt.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_gateway'); ?>
		<?php echo $form->dropDownList($model,'sms_gateway',array(''=>'Bitte auswaehlen',1=>'BulkSMS',2=>'Hetzner')); ?>
		<?php echo $form->error($model,'sms_gateway'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Hinzufuegen' : 'Speichern'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
