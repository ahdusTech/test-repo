<?php
/* @var $this ParamConfigurationController */
/* @var $model ParamConfiguration */

$this->breadcrumbs=array(
	'Param Configurations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ParamConfiguration', 'url'=>array('index')),
	array('label'=>'Manage ParamConfiguration', 'url'=>array('admin')),
);
?>

<h1>Create ParamConfiguration</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>