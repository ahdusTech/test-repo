<?php
/* @var $this TblSaleController */
/* @var $model TblSale */

$this->breadcrumbs=array(
	'Verkaeufe'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Bearbeiten',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
//	array('label'=>'Verkauf erfassen', 'url'=>array('create')),
	array('label'=>'Details', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Verkaufsdetails bearbeiten';
?>

<h1>Verkauf <?php echo $model->id; ?> (Domain
<?php echo TblDomain::model()->findByPk($model->domain)->name;?>)
bearbeiten</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
