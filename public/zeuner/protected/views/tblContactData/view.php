<?php
/* @var $this TblContactDataController */
/* @var $model TblContactData */
/* @var $domain TblDomain */

$this->breadcrumbs=array(
	'Domain-Anfragen'=>array('index'),
	$domain->name . ': ' . $model->name,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Details zur Domain-Anfrage #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'label' => 'Domain',
			'type' => 'raw',
			'value' => $domain->name,
		),
		'name',
		'email',
		'contacted_on',
	),
)); ?>
