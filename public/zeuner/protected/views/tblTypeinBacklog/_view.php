<?php
/* @var $this TblTypeinBacklogController */
/* @var $data TblTypeinBacklog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->domain), array('view', 'id'=>$data->domain)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aggregated_on')); ?>:</b>
	<?php echo CHtml::encode($data->aggregated_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog0')); ?>:</b>
	<?php echo CHtml::encode($data->backlog0); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog1')); ?>:</b>
	<?php echo CHtml::encode($data->backlog1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog2')); ?>:</b>
	<?php echo CHtml::encode($data->backlog2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog3')); ?>:</b>
	<?php echo CHtml::encode($data->backlog3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog4')); ?>:</b>
	<?php echo CHtml::encode($data->backlog4); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog5')); ?>:</b>
	<?php echo CHtml::encode($data->backlog5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog6')); ?>:</b>
	<?php echo CHtml::encode($data->backlog6); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog7')); ?>:</b>
	<?php echo CHtml::encode($data->backlog7); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog8')); ?>:</b>
	<?php echo CHtml::encode($data->backlog8); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backlog9')); ?>:</b>
	<?php echo CHtml::encode($data->backlog9); ?>
	<br />

	*/ ?>

</div>