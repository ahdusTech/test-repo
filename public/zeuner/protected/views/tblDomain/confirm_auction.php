<?php
/* @var $this  TblDomainController
   @var $model TblDomain
*/

$this->pageTitle=$model->name;
?>

<h1><i><?php echo CHtml::encode($model->name); ?></i> kaufen</h1>

<p>Sie k&ouml;nnen nun eine holl&auml;ndische Auktion f&uuml;r die Domain
<i><?php echo CHtml::encode($model->name); ?></i> starten, die mit einem
Preis von <?php echo CHtml::encode($model->auction_start_price . " EUR"); ?>

beginnt und <?php echo CHtml::encode($model->get_auction_duration()); ?> Tage
dauert. Sollte sich in dieser Zeit kein K&auml;ufer finden, erhalten Sie
die Domain automatisch zu einem Preis von nur
<?php echo CHtml::encode($model->lowest_price() . " EUR"); ?>.
<?php echo CHtml::beginForm(
    array(
        'confirm_auction',
        'id' => $model->id,
    )
); ?>
<p>Wir haben Ihnen einen Bestaetigungscode per SMS an die von Ihnen
hinterlegte Telefonnummer geschickt. Bitte geben Sie den Bestaetigungscode
ein, um fortzufahren.</p>
<div>
  <?php echo CHtml::label('Bestaetigungscode', 'verification_code'); ?>
  <?php echo CHtml::textField(
    'verification_code',
    '',
    array(
        'id' => 'verification_code'
    )
); ?>
  <?php echo CHtml::submitButton('Fortfahren'); ?>
  <?php echo CHtml::endForm(); ?>
</div>
