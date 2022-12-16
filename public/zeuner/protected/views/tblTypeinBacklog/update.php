<?php
/* @var $this TblTypeinBacklogController */
/* @var $model TblTypeinBacklog */

$this->breadcrumbs=array(
	'Tbl Typein Backlogs'=>array('index'),
	$model->domain=>array('view','id'=>$model->domain),
	'Update',
);

$this->menu=array(
	array('label'=>'List TblTypeinBacklog', 'url'=>array('index')),
	array('label'=>'Create TblTypeinBacklog', 'url'=>array('create')),
	array('label'=>'View TblTypeinBacklog', 'url'=>array('view', 'id'=>$model->domain)),
	array('label'=>'Manage TblTypeinBacklog', 'url'=>array('admin')),
);
?>

<h1>Update TblTypeinBacklog <?php echo $model->domain; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>