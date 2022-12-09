<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Eingabefelder mit <span class="required">*</span> werden ben&ouml;tigt.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_plain'); ?>
		<?php echo $form->passwordField($model,'password_plain',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password_plain'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_again'); ?>
		<?php echo $form->passwordField($model,'password_again',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password_again'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textField($model,'company_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'company_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->dropDownList($model,'title',array(''=>'Bitte auswaehlen','Frau'=>'Frau','Herr'=>'Herr')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activation_key'); ?>
		<?php echo $form->textField($model,'activation_key',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'activation_key'); ?>
	</div>

	<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'created_on'); ?>
		<?php echo $form->textField($model,'created_on'); ?>
		<?php echo $form->error($model,'created_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_on'); ?>
		<?php echo $form->textField($model,'updated_on'); ?>
		<?php echo $form->error($model,'updated_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_visit_on'); ?>
		<?php echo $form->textField($model,'last_visit_on'); ?>
		<?php echo $form->error($model,'last_visit_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_set_on'); ?>
		<?php echo $form->textField($model,'password_set_on'); ?>
		<?php echo $form->error($model,'password_set_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sms_verification_required'); ?>
		<div>
			<?php echo $form->radioButton($model,'sms_verification_required',array('value'=>1,'uncheckValue'=>NULL)); ?>
			<span>ja</span>
			<?php echo $form->radioButton($model,'sms_verification_required',array('value'=>0,'uncheckValue'=>NULL)); ?>
			<span>nein</span>
		</div>
		<?php echo $form->error($model,'sms_verification_required'); ?>
	</div>

	*/ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'email_verified'); ?>
		<div>
			<?php echo $form->radioButton($model,'email_verified',array('value'=>1,'uncheckValue'=>NULL)); ?>
			<span>ja</span>
			<?php echo $form->radioButton($model,'email_verified',array('value'=>0,'uncheckValue'=>NULL)); ?>
			<span>nein</span>
		</div>
		<?php echo $form->error($model,'email_verified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<div>
			<?php echo $form->radioButton($model,'is_active',array('value'=>1,'uncheckValue'=>NULL)); ?>
			<span>ja</span>
			<?php echo $form->radioButton($model,'is_active',array('value'=>0,'uncheckValue'=>NULL)); ?>
			<span>nein</span>
		</div>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_disabled'); ?>
		<div>
			<?php echo $form->radioButton($model,'is_disabled',array('value'=>1,'uncheckValue'=>NULL)); ?>
			<span>ja</span>
			<?php echo $form->radioButton($model,'is_disabled',array('value'=>0,'uncheckValue'=>NULL)); ?>
			<span>nein</span>
		</div>
		<?php echo $form->error($model,'is_disabled'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zipcode'); ?>
		<?php echo $form->textField($model,'zipcode',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'zipcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vat_id'); ?>
		<?php echo $form->textField($model,'vat_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'vat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<?php if (!$model->isNewRecord) { ?>
		<?php echo $form->hiddenField($model,'terms_agreed'); ?>
	<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Erstellen' : 'Speichern'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
