<?php
/* @var $this TblMailTemplateController */
/* @var $model TblMailTemplate */

$this->breadcrumbs=array(
	'Mail-Vorlagen'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Vorlage', 'url'=>array('create')),
	array('label'=>'Details', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Mail-Vorlage <?php echo $model->title; ?> bearbeiten</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
