<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Modify',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'New domain', 'url'=>array('create')),
	array('label'=>'Details', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Filter', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'modify domain';
?>

<h1>Modify domain <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
