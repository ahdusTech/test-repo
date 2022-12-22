<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */
/* @var $contact_data TblContactData */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	$model->name=>array('view', 'id'=>$model->id),
	'Anfragen',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
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

<h1>Manage Tbl Contact Datas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search_contacts',array(
	'model'=>$contact_data,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tbl-contact-data-grid',
	'dataProvider'=>$contact_data->search(),
	'filter'=>$contact_data,
	'columns'=>array(
		'id',
		'name',
		'email',
		'contacted_on',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{mail}',
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
