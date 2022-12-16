<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Benutzer',
);

$this->menu=array(
	array('label'=>'Neuer Benutzer', 'url'=>array('create')),
//	array('label'=>'Freischaltung erwartet', 'url'=>array('index_disabled')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Benutzer';
?>

<h1>Benutzer</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText'=>'Keine Eintraege gefunden',
)); ?>
