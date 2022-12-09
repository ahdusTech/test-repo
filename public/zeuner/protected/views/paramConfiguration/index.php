<?php
/* @var $this ParamConfigurationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Param Configurations',
);

$this->menu=array(
	array('label'=>'Create ParamConfiguration', 'url'=>array('create')),
	array('label'=>'Manage ParamConfiguration', 'url'=>array('admin')),
);
?>

<h1>Param Configurations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
