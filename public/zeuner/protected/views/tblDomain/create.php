<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	'Hinzufuegen',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Domain hinzufuegen';
?>

<h1>Neue Domain erfassen</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
