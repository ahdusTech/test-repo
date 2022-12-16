<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Benutzer'=>array('index'),
	'Freischaltung erwartet',
);

$this->menu=array(
	array('label'=>'Neuer Benutzer', 'url'=>array('create')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Nutzer freischalten';
?>

<h1>Angemeldete Benutzer, die auf Freischaltung warten</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText'=>'Keine Eintraege gefunden',
)); ?>
