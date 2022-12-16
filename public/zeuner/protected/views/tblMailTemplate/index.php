<?php
/* @var $this TblMailTemplateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mail-Vorlagen',
);

$this->menu=array(
	array('label'=>'Neue Vorlage', 'url'=>array('create')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Mail-Vorlagen</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
