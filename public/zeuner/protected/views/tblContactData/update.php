<?php
/* @var $this TblContactDataController */
/* @var $model TblContactData */

$this->breadcrumbs=array(
	'Domain-Anfragen'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'View TblContactData', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Update TblContactData <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>