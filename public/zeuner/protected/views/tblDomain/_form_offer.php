<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */
/* @var $user User */
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

	<input type="hidden" name="user" value="<?php echo $user->id; ?>"/>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo CHtml::radioButtonList(
				'calculation_method',
				'round_down_exact_days',
				array(
					'round_down_exact_days' => 'Schrittgroesse abrunden, exakt 30 Tage',
					'round_up_exact_days' => 'Schrittgroesse aufrunden, exakt 30 Tage',
					'round_down_flexible_days' => 'Schrittgroesse abrunden, Dauer flexibel',
					'round_up_flexible_days' => 'Schrittgroesse aufrunden, Dauer flexibel',
				),
				array(
					'class' => 'radio_calculation_method',
				)
			); ?>
	</div>

	<div class="row">
		<label for="list_price">Listpreis</label>
		<input class="field_list_price" name="list_price" value="<?php echo $model->auction_start_price; ?>"/>
	</div>

	<div class="row">
		<label for="customer_price">Mindestpreis (Kundenwunsch)</label>
		<input class="field_customer_price" name="customer_price" value=""/>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'auction_start_price'); ?>
		<?php echo $form->textField($model,'auction_start_price',array('class' => 'field_auction_start_price', 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'auction_start_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'auction_price_step'); ?>
		<?php echo $form->textField($model,'auction_price_step',array('class' => 'field_auction_price_step', 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'auction_price_step'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'auction_duration'); ?>
		<?php echo $form->textField($model,'auction_duration',array('class' => 'field_auction_duration', 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'auction_duration'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Link erzeugen'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
