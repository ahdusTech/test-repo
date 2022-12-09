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
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Anfragen ansehen', 'url'=>array('index_contacts', 'id'=>$model->id)),
	array('label'=>'Gebot loeschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete_bid','id'=>$model->id),'confirm'=>'Sind Sie sicher? Der Erstinteressent erhaelt die Domain zum Mindestpreis.', 'csrf' => TRUE)),
	array('label'=>'Auktion neu starten', 'url'=>'#', 'linkOptions'=>array('submit'=>array('restart_auction','id'=>$model->id),'confirm'=>'Sind Sie sicher, dass Sie die Auktion neu starten moechten?', 'csrf' => TRUE)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Verkaufsstatus';
?>

<h1>Verkaufsstatus Domain <?php echo $model->name; ?> (#<?php echo $model->id; ?>)</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'auction_start_price',
		array(
			'label' => 'Mindestpreis (EUR)',
			'type' => 'raw',
			'value' => $model->lowest_price(
			),
		),
		array(
			'label' => 'erzielter Preis (EUR)',
			'type' => 'raw',
			'value' => $sale->price,
		),
		array(
			'label' => 'Kaufzeitpunkt',
			'type' => 'raw',
			'value' => $sale->sold_at,
		),
		array(
			'label' => 'Veranstalter',
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
		array(
			'label' => 'CPC-Override',
			'type' => 'raw',
			'value' => (
				0 > $model->cpc_override
			) ? "-" : $model->cpc_override,
		),
		array(
			'label' => 'berechneter Preis (EUR)',
			'type' => 'raw',
			'value' => $model->computed_price(
			),
		),
	),
)); ?>
