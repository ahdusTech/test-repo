<?php
/* @var $this TblSaleController */
/* @var $model TblSale */

$this->breadcrumbs=array(
	'Verkaeufe'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Create TblSale</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>