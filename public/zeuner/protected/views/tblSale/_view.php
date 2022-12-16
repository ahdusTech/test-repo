<?php
/* @var $this TblSaleController */
/* @var $data TblSale */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode(TblDomain::model()->findByPk($data->domain)->name), array('tblDomain/view', 'id'=>$data->domain)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode('#' . $data->buyer), array('user/view', 'id'=>$data->buyer));; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sold_at')); ?>:</b>
	<?php echo CHtml::encode($data->sold_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid')); ?>:</b>
	<?php echo CHtml::encode($data->paid ? "ja" : "nein"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />


</div>
