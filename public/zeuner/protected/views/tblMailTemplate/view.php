<?php
/* @var $this TblMailTemplateController */
/* @var $model TblMailTemplate */

$this->breadcrumbs=array(
	'Mail-Vorlagen'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Vorlage', 'url'=>array('create')),
	array('label'=>'Bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Loeschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Details zu Mail-Vorlage #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'subject',
		'content',
		'last_change',
	),
)); ?>
