<?php
/* @var $this TblSaleController */
/* @var $sale TblSale */
/* @var $domain TblDomain */

$this->breadcrumbs=array(
	'Kaeufe'=>array('index_own'),
	$sale->id,
);

$this->menu=array(
	array('label'=>'Uebersicht', 'url'=>array('index_own')),
);

$this->pageTitle = 'Kaufstatus ' . $domain->name;
?>

<h1>Kauf der Domain <?php echo $domain->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$sale,
	'attributes'=>array(
		array(
			'label' => 'Domainname',
			'type' => 'raw',
			'value' => $domain->name,
		),
		array(
			'label' => 'Kaufdatum',
			'type' => 'date',
			'value' => $sale->sold_at,
		),
		array(
			'label' => 'bezahlt?',
			'type' => 'raw',
			'value' => $sale->paid ? "ja" : "nein",
		),
		'price',
	),
)); ?>
