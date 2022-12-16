<?php
/* @var $this TblSaleController */
/* @var $model TblSale */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbl-sale-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Eingabefelder mit <span class="required">*</span> werden ben&ouml;tigt.</p>

	<?php echo $form->errorSummary($model); ?>

<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'domain'); ?>
		<?php echo $form->textField($model,'domain'); ?>
		<?php echo $form->error($model,'domain'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer'); ?>
		<?php echo $form->textField($model,'buyer'); ?>
		<?php echo $form->error($model,'buyer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sold_at'); ?>
		<?php echo $form->textField($model,'sold_at'); ?>
		<?php echo $form->error($model,'sold_at'); ?>
	</div>
*/ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'paid'); ?>
                <div>   
                        <?php echo $form->radioButton($model,'paid',array('value'=>1,'uncheckValue'=>NULL)); ?>
                        <span>ja</span>
                        <?php echo $form->radioButton($model,'paid',array('value'=>0,'uncheckValue'=>NULL)); ?>
                        <span>nein</span>
                </div>
		<?php echo $form->error($model,'paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
