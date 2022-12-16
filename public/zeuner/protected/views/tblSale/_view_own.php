<?php
/* @var $this TblSaleController */
/* @var $data TblSale */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode(TblDomain::model()->findByPk($data->domain)->name), array('status', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode("Kaufzeitpunkt"); ?>:</b>
	<?php echo CHtml::encode($data->sold_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid')); ?>:</b>
	<?php echo CHtml::encode($data->paid ? "ja" : "nein"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />


</div>
