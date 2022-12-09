<?php
/* @var $this TblSaleController */
/* @var $model TblSale */

$this->breadcrumbs=array(
	'Verkaeufe'=>array('index'),
	'Suchen',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
//	array('label'=>'Verkauf erfassen', 'url'=>array('create')),
);

$this->pageTitle = Yii::app()->name.' - '.'Verkaeufe suchen';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbl-sale-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Verk&auml;ufe verwalten</h1>

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
	'id'=>'tbl-sale-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'domain',
		'buyer',
		'sold_at',
		'paid',
		'price',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
