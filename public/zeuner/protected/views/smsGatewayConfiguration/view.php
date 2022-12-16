<?php
/* @var $this SmsGatewayConfigurationController */
/* @var $model SmsGatewayConfiguration */

$this->breadcrumbs=array(
	'Sms Gateway Configurations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SmsGatewayConfiguration', 'url'=>array('index')),
	array('label'=>'Create SmsGatewayConfiguration', 'url'=>array('create')),
	array('label'=>'Update SmsGatewayConfiguration', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SmsGatewayConfiguration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SmsGatewayConfiguration', 'url'=>array('admin')),
);
?>

<h1>View SmsGatewayConfiguration #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sms_gateway',
	),
)); ?>
