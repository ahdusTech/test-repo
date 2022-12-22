<?php
/* @var $this TblContactDataController */
/* @var $dataProvider CActiveDataProvider */
/* @var $domain TblDomain */
/* @var $contact_data TblContactData */

$this->breadcrumbs=array(
	'Domains'=>array('tblDomain/index'),
	$domain->name=>array('tblDomain/view', 'id'=>$domain->id),
	'Nachricht an ' . $contact_data->name,
);

$this->menu=array(
	array('label'=>'Liste', 'url'=>array('tblDomain/index')),
	array('label'=>'Neue Domain', 'url'=>array('tblDomain/create')),
	array('label'=>'Bearbeiten', 'url'=>array('tblDomain/update', 'id'=>$domain->id)),
	array('label'=>'Filtern', 'url'=>array('tblDomain/admin')),
);
?>

<h1>Nachricht an <?php echo $contact_data->name; ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_mail_template',
	'viewData' => array(
		'contact_data' => $contact_data,
	),
)); ?>
