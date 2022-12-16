<?php
/* @var $this TblDomainController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Domains',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Domains';
?>

<h1>Domains</h1>

<?php if (Yii::app()->user->hasFlash('domain')) { ?>

<p class="flash-success">
        <?php echo Yii::app()->user->getFlash('domain'); ?>
</p>

<?php } ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText'=>'Keine Eintraege gefunden',
)); ?>
