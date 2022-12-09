<?php
/* @var $this TblContactDataController */
/* @var $model OutboundForm */
/* @var $domain TblDomain */
/* @var $contact_data TblContactData */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'Domains'=>array('tblDomain/index'),
	$domain->name=>array('tblDomain/view', 'id'=>$domain->id),
	'Nachricht an ' . $contact_data->name,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('tblDomain/index')),
	array('label'=>'Neue Domain', 'url'=>array('tblDomain/create')),
	array('label'=>'Bearbeiten', 'url'=>array('tblDomain/update', 'id'=>$domain->id)),
	array('label'=>'Filtern', 'url'=>array('tblDomain/admin')),
);
?>

<h1>Nachricht an <?php echo $contact_data->name; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'outbound-form-finish_mail-form',
	'action' => array(
		'send_mail',
		'id' => $contact_data->id,
	),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
