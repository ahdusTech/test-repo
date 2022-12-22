<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Benutzer'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Benutzer erfassen';
?>

<h1>Neuer Benutzer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
