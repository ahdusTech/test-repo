<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Bearbeiten',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Details', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Domain bearbeiten';
?>

<h1>Domain <?php echo $model->name; ?> bearbeiten</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
