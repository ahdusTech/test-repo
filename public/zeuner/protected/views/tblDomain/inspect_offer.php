<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */
/* @var $user User */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Angebotsstatus Domain <?php echo $model->name; ?> (#<?php echo $model->id; ?>)</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		array(
			'label' => 'Auktionsstatus',
			'type' => 'raw',
			'value' => (
				1 == $model->auction
			) ? "aktiv" : "inaktiv",
		),
		'auction_start_price',
		'auction_price_step',
		array(
			'label' => 'Dauer (Tage)',
			'type' => 'raw',
			'value' => $model->get_auction_duration(
			),
		),
		array(
			'label' => 'Mindestpreis (EUR)',
			'type' => 'raw',
			'value' => $model->lowest_price(
			),
		),
		array(
			'label' => 'Veranstalter',
			'type' => 'raw',
			'value' => CHtml::link(
				CHtml::encode(
					$user->firstname . " " . $user->lastname
				),
				array(
					"User/view",
					"id" => $user->id,
				)
			),
		),
		array(
			'label' => 'Link fuer den Start der Auktion',
			'type' => 'raw',
			'value' => CHtml::encode(
				$this->createAbsoluteUrl(
					'start_auction',
					array(
						'id' => $model->id,
					)
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
