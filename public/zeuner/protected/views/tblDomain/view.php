<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Zur Auktion freigeben', 'url'=>array('prepare_offer', 'id'=>$model->id)),
	array('label'=>'Loeschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Sind Sie sicher, dass Sie diese Domain aus dem System loeschen moechten?', 'csrf' => TRUE)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Details Domain <?php echo $model->name; ?> (#<?php echo $model->id; ?>)</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'auction:boolean',
		'auction_begin',
		'auction_start_price',
		'auction_price_step',
		'initiator',
		'sold',
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
