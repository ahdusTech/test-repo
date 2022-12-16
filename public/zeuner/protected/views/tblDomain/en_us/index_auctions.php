<?php
/* @var $this TblDomainController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auctions',
);

$this->menu=array(
);

$this->pageTitle = 'Auctions';
?>

<h1>Currently running auctions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_auctions',
	'emptyText'=>'No auctions running currently.',
)); ?>
