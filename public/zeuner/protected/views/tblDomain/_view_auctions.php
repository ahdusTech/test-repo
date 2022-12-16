<?php
/* @var $this TblDomainController */
/* @var $data TblDomain */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('site/index', 'domain' => $data->name)); ?>
	<br />

	<b>aktueller Preis (EUR):</b>
	<?php echo CHtml::encode($data->get_current_price()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auction_start_price')); ?>:</b>
	<?php echo CHtml::encode($data->auction_start_price); ?>
	<br />

	<b>n&auml;chste Preissenkung:</b>
	<span class="remaining"></span>
	<br />


</div>
