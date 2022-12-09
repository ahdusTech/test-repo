<?php
/* @var $this TblDomainController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auktionen',
);

$this->menu=array(
);

$this->pageTitle = 'Auktionen';
?>

<h1>Derzeit laufende Auktionen</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_auctions',
	'emptyText'=>'Derzeit laufen keine Auktionen',
)); ?>
