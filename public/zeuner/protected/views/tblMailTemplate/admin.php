<?php
/* @var $this TblMailTemplateController */
/* @var $model TblMailTemplate */

$this->breadcrumbs=array(
	'Mail-Vorlagen'=>array('index'),
	'Filtern',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Vorlage', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbl-mail-template-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Mail-Vorlagen verwalten</h1>

<p>
Sie k&ouml;nnen auch Vergleichsoperatoren (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) am Beginn eines beliebigen Suchwertes eingeben, um festzulegen,
wie der Vergleich in der Datenbank vorgenommen werden soll.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tbl-mail-template-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'subject',
		'content',
		'last_change',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
