<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	'Suchen',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Domains suchen';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbl-domain-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Domains suchen</h1>

<p>
Sie k&ouml;nnen auch Vergleichsoperatoren (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) am Beginn eines beliebigen Suchwertes eingeben, um festzulegen,
wie der Vergleich in der Datenbank vorgenommen werden soll.
</p>

<?php echo CHtml::link('Erweiterte Suche','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tbl-domain-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'auction',
		'auction_begin',
		'auction_start_price',
		'auction_price_step',
		'initiator',
		'sold',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
