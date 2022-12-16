<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */
/* @var $sale TblSale */
/* @var $buyer User */
/* @var $initiator User */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
	array('label'=>'New domain', 'url'=>array('create')),
	array('label'=>'Modify', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'View requests', 'url'=>array('index_contacts', 'id'=>$model->id)),
	array('label'=>'Delete bid', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete_bid','id'=>$model->id),'confirm'=>'Are you sure? The first prospective buyer will get the domain at the minimum price.', 'csrf' => TRUE)),
	array('label'=>'Restart auction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('restart_auction','id'=>$model->id),'confirm'=>'Are you sure that you want to restart the auction?', 'csrf' => TRUE)),
	array('label'=>'Filter', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'sale status';
?>

<h1>Sale status for domain <?php echo $model->name; ?> (#<?php echo $model->id; ?>)</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'auction_start_price',
		array(
			'label' => 'minimum price (EUR)',
			'type' => 'raw',
			'value' => $model->lowest_price(
			),
		),
		array(
			'label' => 'reached price (EUR)',
			'type' => 'raw',
			'value' => $sale->price,
		),
		array(
			'label' => 'time of sale',
			'type' => 'raw',
			'value' => $sale->sold_at,
		),
		array(
			'label' => 'promoter',
			'type' => 'raw',
			'value' => CHtml::link(
				CHtml::encode(
					$initiator->firstname . " " . $initiator->lastname
				),
				array(
					"User/view",
					"id" => $initiator->id,
				)
			),
		),
		array(
			'label' => 'buyer',
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
		array(
			'label' => 'CPC-Override',
			'type' => 'raw',
			'value' => (
				0 > $model->cpc_override
			) ? "-" : $model->cpc_override,
		),
		array(
			'label' => 'computed price (EUR)',
			'type' => 'raw',
			'value' => $model->computed_price(
			),
		),
	),
)); ?>
