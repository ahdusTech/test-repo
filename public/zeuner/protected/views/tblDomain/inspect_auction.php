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
	array('label'=>'Anfragen ansehen', 'url'=>array('index_contacts', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Auktionsstatus Domain <?php echo $model->name; ?> (#<?php echo $model->id; ?>)</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'auction_begin',
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
			'label' => 'aktueller Preis (EUR)',
			'type' => 'raw',
			'value' => $model->get_current_price(
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
	),
)); ?>
