<?php
/* @var $this TblSaleController */
/* @var $model TblSale */
/* @var $buyer User */
/* @var $domain TblDomain */

$this->breadcrumbs=array(
	'Verkaeufe'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
//	array('label'=>'Verkauf erfassen', 'url'=>array('create')),
	array('label'=>'Bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Loeschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?', 'csrf' => TRUE)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Verkaufsdetails';
?>

<h1>Details zum Verkauf #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'label' => 'Domain',
			'type' => 'raw',
			'value' => CHtml::link(
				CHtml::encode(
					$domain->name
				),
				array(
					"TblDomain/view",
					"id" => $domain->id,
				)
			),
		),
		array(
			'label' => 'Kaeufer',
			'type' => 'raw',
			'value' => CHtml::link(
				CHtml::encode(
					$buyer->firstname . " " . $buyer->lastname
				),
				array(
					"User/view",
					"id" => $buyer->id,
				)
			),
		),
		'sold_at',
		'paid',
		'price',
	),
)); ?>
