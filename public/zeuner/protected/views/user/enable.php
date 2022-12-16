<?php
/* @var $this  UserController
   @var $model User
*/

$this->pageTitle=Yii::app()->name . ' - Aktivierung';
?>

<h1><?php echo CHtml::encode(Yii::app()->name . ' - Aktivierung'); ?></h1>

<?php echo CHtml::beginForm(
    array(
        'enable',
        'id' => $model->id,
    )
); ?>
<p>Wir haben Ihnen einen Best&auml;tigungscode per SMS an die von Ihnen
hinterlegte Telefonnummer <?php echo $model->phone; ?> geschickt. Bitte geben
Sie den Best&auml;tigungscode ein, um Ihre Registrierung zu aktivieren.</p>
<div>
  <?php echo CHtml::label('Bestaetigungscode', 'verification_code'); ?>
  <?php echo CHtml::textField(
    'verification_code',
    '',
    array(
        'id' => 'verification_code'
    )
); ?>
  <?php echo CHtml::submitButton('aktivieren'); ?>
  <?php echo CHtml::endForm(); ?>

<?php if (Yii::app()->user->hasFlash('verification')) { ?>
<div class="flash-error">
        <?php echo Yii::app()->user->getFlash('verification'); ?>
</div>
<?php } ?>
</div>
