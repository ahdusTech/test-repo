<?php
/* @var $this SmsGatewayConfigurationController */
/* @var $model SmsGatewayConfiguration */

$this->breadcrumbs=array(
	'Einstellungen',
	'SMS-Gateway',
);

$this->menu=array(
	array('label'=>'SMS-Gateway', 'url'=>array('smsGatewayConfiguration/update', 'id' => 1)),
	array('label'=>'System-Parameter', 'url'=>array('paramConfiguration/update', 'id' => 1)),
);
?>

<h1>SMS-Gateway konfigurieren</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
