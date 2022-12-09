<?php
/* @var $this ParamConfigurationController */
/* @var $model ParamConfiguration */

$this->breadcrumbs=array(
	'Param Configurations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ParamConfiguration', 'url'=>array('index')),
	array('label'=>'Create ParamConfiguration', 'url'=>array('create')),
	array('label'=>'Update ParamConfiguration', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ParamConfiguration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ParamConfiguration', 'url'=>array('admin')),
);
?>

<h1>View ParamConfiguration #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'systemEmail',
		'adminEmail',
	),
)); ?>
