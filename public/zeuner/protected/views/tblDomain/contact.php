<?php
/* @var $this TblDomainController */
/* @var $model ContactForm */
/* @var $domain TblDomain */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Kontakt aufnehmen';
$this->breadcrumbs=array(
	'Kontaktieren',
);
?>

<h1>Kontakt aufnehmen</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
Wenn Sie Interesse an der Domain <?php echo $domain->name; ?> haben,
koennen Sie dieses Formular ausfuellen, um Kontakt mit dem Inhaber
aufzunehmen.
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Eingabefelder mit <span class="required">*</span> werden ben&ouml;tigt.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Absenden'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
