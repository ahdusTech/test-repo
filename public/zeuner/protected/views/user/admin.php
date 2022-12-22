<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Benutzer'=>array('index'),
	'Suchen',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neuer Benutzer', 'url'=>array('create')),
);

$this->pageTitle = Yii::app()->name.' - '.'Benutzer suchen';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Benutzer suchen</h1>

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
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'email',
		'title',
		'firstname',
		'lastname',
		'company_name',
		/*
		'activation_key',
		'created_on',
		'updated_on',
		'last_visit_on',
		'password_set_on',
		'email_verified',
		'sms_verification_required',
		'is_active',
		'is_disabled',
		'one_time_password_secret',
		'one_time_password_code',
		'one_time_password_counter',
		'street',
		'zipcode',
		'city',
		'country',
		'vat_id',
		'phone',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
