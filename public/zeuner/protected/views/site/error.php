<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Fehler';
$this->breadcrumbs=array(
	'Fehler',
);
?>

<h2>Fehler <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
