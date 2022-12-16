<?php
/* @var $this SmsGatewayConfigurationController */
/* @var $model SmsGatewayConfiguration */

$this->breadcrumbs=array(
	'Sms Gateway Configurations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SmsGatewayConfiguration', 'url'=>array('index')),
	array('label'=>'Manage SmsGatewayConfiguration', 'url'=>array('admin')),
);
?>

<h1>Create SmsGatewayConfiguration</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>