<?php
/* @var $this TblTypeinBacklogController */
/* @var $model TblTypeinBacklog */

$this->breadcrumbs=array(
	'Tbl Typein Backlogs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TblTypeinBacklog', 'url'=>array('index')),
	array('label'=>'Manage TblTypeinBacklog', 'url'=>array('admin')),
);
?>

<h1>Create TblTypeinBacklog</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>