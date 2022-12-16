<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

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
		<?php echo $form->dropDownList($model,'title',array(''=>'Bitte auswaehlen','Herr'=>'Herr','Frau'=>'Frau')); ?>
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
		<?php echo $form->dropDownList($model,'country',$this->get_countries()); ?>
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

	<div>
		<?php echo $form->checkBox($model,'terms_agreed',array('uncheckValue'=>NULL,'class'=>'complex')); ?>
	        <label class="complex" for="terms_agreed">Ich habe die <?php echo CHtml::link(CHtml::encode("AGB"), array('site/page', 'view'=>'terms'), array('target'=>'_blank')); ?> gelesen und
akzeptiert und erkläre mich damit
einverstanden, dass meine Daten elektronisch verarbeitet und gespeichert
werden. Die Daten werden nicht unbefugt an Dritte weitergegeben.</label>
		<?php echo $form->error($model,'terms_agreed'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrieren' : 'Speichern'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
