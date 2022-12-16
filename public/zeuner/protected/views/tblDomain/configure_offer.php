<?php
/* @var $this TblDomainController */
/* @var $model TblDomain */
/* @var $user User */

$this->breadcrumbs=array(
	'Domains'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Einladung',
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('index')),
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Details', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Filtern', 'url'=>array('admin')),
);
?>

<h1>Einladung f&uuml;r Domain <?php echo $model->name; ?>, Nutzer
<?php echo $user->firstname; ?> <?php echo $user->lastname; ?></h1>

<?php $this->renderPartial('_form_offer', array('model'=>$model, 'user' => $user)); ?>
