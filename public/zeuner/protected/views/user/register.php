<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Anmeldung',
);

$this->menu=array(
);

$this->pageTitle = 'Benutzeranmeldung';
?>

<h1>Benutzeranmeldung</h1>

<?php $this->renderPartial('_form_register', array('model'=>$model)); ?>
