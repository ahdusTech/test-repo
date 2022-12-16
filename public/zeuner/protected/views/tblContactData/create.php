<?php
/* @var $this TblContactDataController */
/* @var $model TblContactData */

$this->breadcrumbs=array(
	'Domain-Anfragen'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Create TblContactData</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>