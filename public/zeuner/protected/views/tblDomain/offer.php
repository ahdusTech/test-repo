<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */
/* @var $domain TblDomain */

$this->breadcrumbs=array(
	'Nutzer',
);

$this->menu=array(
	array('label'=>'Neue Domain', 'url'=>array('create')),
	array('label'=>'Filtern', 'url'=>array('admin')),
);

$this->pageTitle = Yii::app()->name.' - '.'Domain anbieten';
?>

<h1>Kunden einladen, eine Auktion fuer die Domain <?php echo $domain->name; ?>

durchzufuehren:</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_user',
	'viewData' => array(
		'domain' => $domain,
	),
	'ajaxUpdate' => FAlSE,
	'emptyText'=>'Keine Eintraege gefunden',
)); ?>
