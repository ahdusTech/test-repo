<?php
/* @var $this TblSaleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Verkaeufe',
);

$this->menu=array(
//	array('label'=>'Verkauf erfassen', 'url'=>array('create')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Verkaeufe';
?>

<h1>Verkaeufe</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText'=>'Keine Eintraege gefunden',
)); ?>
