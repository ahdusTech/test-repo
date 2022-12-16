<?php
/* @var $this TblTypeinStatsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Typeins',
);

$this->menu=array(
);

$this->pageTitle = Yii::app()->name.' - '.'Typeins';
?>

<h1>Typeins</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
