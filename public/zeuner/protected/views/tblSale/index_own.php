<?php
/* @var $this TblSaleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Kaeufe',
);

$this->menu=array(
);

$this->pageTitle = 'Kaeufe';
?>

<h1>Uebersicht Ihrer Kaeufe</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_own',
	'emptyText'=>'Keine Eintraege gefunden',
)); ?>
