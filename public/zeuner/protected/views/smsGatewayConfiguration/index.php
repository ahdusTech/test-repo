<?php
/* @var $this SmsGatewayConfigurationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sms Gateway Configurations',
);

$this->menu=array(
	array('label'=>'Create SmsGatewayConfiguration', 'url'=>array('create')),
	array('label'=>'Manage SmsGatewayConfiguration', 'url'=>array('admin')),
);
?>

<h1>Sms Gateway Configurations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
