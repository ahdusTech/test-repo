<?php
/* @var $this TblMailTemplateController */
/* @var $model TblMailTemplate */

$this->breadcrumbs=array(
	'Mail-Vorlagen'=>array('index'),
	'Neu',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Neue Vorlage</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
