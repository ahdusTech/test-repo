<?php
/* @var $this TblContactDataController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Domain-Anfragen',
);

$this->menu=array(
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Domain-Anfragen</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
