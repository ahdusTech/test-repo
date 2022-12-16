<?php
/* @var $this ParamConfigurationController */
/* @var $data ParamConfiguration */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_gateway')); ?>:</b>
	<?php echo CHtml::encode($data->sms_gateway); ?>
	<br />


</div>