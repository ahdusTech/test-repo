<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Benutzer'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neuer Benutzer', 'url'=>array('create')),
//	array('label'=>'Freischalten', 'url'=>'#', 'linkOptions'=>array('submit'=>array('admin_enable','id'=>$model->id), 'csrf' => TRUE)),
	array('label'=>'Bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Loeschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Sind Sie sicher, dass Sie den Nutzer loeschen moechten?', 'csrf' => TRUE)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Details Benutzer';
?>

<h1>Benutzer ansehen #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		//'password',
		'email',
		'company_name',
		'title',
		'firstname',
		'lastname',
		'activation_key',
		//'created_on',
		//'updated_on',
		//'last_visit_on',
		//'password_set_on',
		'email_verified:boolean',
		//'sms_verification_required:boolean',
		'is_active:boolean',
		'is_disabled:boolean',
		/*
		'one_time_password_secret',
		'one_time_password_code',
		'one_time_password_counter',
		*/
		'street',
		'zipcode',
		'city',
		'country',
		'vat_id',
		'phone',
	),
)); ?>
