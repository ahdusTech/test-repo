<?php
/* @var $this TblDomainController */
/* @var $data TblDomain */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auction')); ?>:</b>
	<?php echo CHtml::encode($data->auction ? "aktiv" : "inaktiv"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auction_begin')); ?>:</b>
	<?php echo CHtml::encode($data->auction_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auction_start_price')); ?>:</b>
	<?php echo CHtml::encode($data->auction_start_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auction_price_step')); ?>:</b>
	<?php echo CHtml::encode($data->auction_price_step); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('initiator')); ?>:</b>
	<?php echo $data->initiator ? CHtml::link(CHtml::encode('#' . $data->initiator), array('user/view', 'id'=>$data->initiator)) : "nein"; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sold')); ?>:</b>
	<?php echo CHtml::encode($data->sold ? "ja" : "nein"); ?>
	<br />


</div>
