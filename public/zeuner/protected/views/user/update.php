<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Benutzer'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Bearbeiten',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neuer Benutzer', 'url'=>array('create')),
	array('label'=>'Benutzer ansehen', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Benutzerdaten bearbeiten';
?>

<h1>Benutzer <?php echo $model->id; ?> bearbeiten</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
