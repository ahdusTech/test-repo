<?php
/* @var $this  TblDomainController
   @var $model TblDomain
*/

$this->pageTitle=$model->name;

$this->breadcrumbs=array(
	'Domains'=>array('index_own'),
	$model->name,
);
?>

<h1><i><?php echo CHtml::encode($model->name); ?></i> kaufen</h1>

<p>Sie k&ouml;nnen nun eine holl&auml;ndische Auktion f&uuml;r die Domain
<i><?php echo CHtml::encode($model->name); ?></i> starten, die mit einem
Preis von <?php echo CHtml::encode($model->auction_start_price . " EUR"); ?>

beginnt und <?php echo CHtml::encode($model->get_auction_duration()); ?> Tage
dauert. Sollte sich in dieser Zeit kein K&auml;ufer finden, erhalten Sie
die Domain automatisch zu einem Preis von nur
<?php echo CHtml::encode($model->lowest_price() . " EUR"); ?>.
<p><?php echo CHtml::link('Auktion starten',
    '#',
    array(
        'submit' => array(
            'confirm_auction',
        ),
        'params' => array(
            'id' => $model->id,
        ),
        'csrf' => TRUE,
    )
); ?></p>
