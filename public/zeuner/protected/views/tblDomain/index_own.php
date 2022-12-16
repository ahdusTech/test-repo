<?php
/* @var $this TblDomainController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Domains',
);

$this->menu=array(
);

$this->pageTitle = 'Domains';
?>

<h1>Domains</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_own',
	'emptyText'=>'Keine Eintraege gefunden',
)); ?>
