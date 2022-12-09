<?php
/* @var $this ParamConfigurationController */
/* @var $model ParamConfiguration */

$this->breadcrumbs=array(
	'Einstellungen',
	'System-Parameter',
);

$this->menu=array(
	array('label'=>'SMS-Gateway', 'url'=>array('smsGatewayConfiguration/update', 'id' => 1)),
	array('label'=>'System-Parameter', 'url'=>array('paramConfiguration/update', 'id' => 1)),
);
?>

<h1>System-Parameter konfigurieren</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
