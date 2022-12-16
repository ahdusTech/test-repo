<?php
/* @var $this TblTypeinStatsController */
/* @var $data TblTypeinStats */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode(TblDomain::model()->findByPk($data->domain)->name), array('index_domain', 'id'=>$data->domain)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accesses')); ?>:</b>
	<?php echo CHtml::encode($data->accesses); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access_date')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->access_date), array('index_date', 'date'=>$data->access_date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('counted_on')); ?>:</b>
	<?php echo CHtml::encode($data->counted_on); ?>
	<br />


</div>
