<?php
/* @var $this TblContactDataController */
/* @var $model TblContactData */

$this->breadcrumbs=array(
	'Domain-Anfragen'=>array('index'),
	'Filtern',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbl-contact-data-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Domain-Anfragen verwalten</h1>

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
	'id'=>'tbl-contact-data-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'domain',
		'name',
		'email',
		'contacted_on',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {mail}',
			'buttons'=>array(
				'mail'=>array(
					'label'=>'E-Mail schicken',
					'imageUrl'=>Yii::app(
					)->request->baseUrl.'/images/envelope.png',
					'url'=>'Yii::app()->createUrl(
    "tblContactData/choose_template",
    array(
        "id"=>$data->id
    )
)',
				),
			),
		),
	),
)); ?>
