<?php
/* @var $this TblTypeinBacklogController */
/* @var $model TblTypeinBacklog */

$this->breadcrumbs=array(
	'Tbl Typein Backlogs'=>array('index'),
	$model->domain,
);

$this->menu=array(
	array('label'=>'List TblTypeinBacklog', 'url'=>array('index')),
	array('label'=>'Create TblTypeinBacklog', 'url'=>array('create')),
	array('label'=>'Update TblTypeinBacklog', 'url'=>array('update', 'id'=>$model->domain)),
	array('label'=>'Delete TblTypeinBacklog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->domain),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TblTypeinBacklog', 'url'=>array('admin')),
);
?>

<h1>View TblTypeinBacklog #<?php echo $model->domain; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'domain',
		'aggregated_on',
		'backlog0',
		'backlog1',
		'backlog2',
		'backlog3',
		'backlog4',
		'backlog5',
		'backlog6',
		'backlog7',
		'backlog8',
		'backlog9',
	),
)); ?>
