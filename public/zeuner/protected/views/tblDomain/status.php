<?php
/* @var $this  SiteController
   @var $model TblDomain
   @var $now   string
   @var $price integer
*/

$this->pageTitle=$model->name;
?>

<h1>Zum Verkauf steht: <i><?php echo CHtml::encode($model->name); ?></i></h1>

<p>N&auml;chste Preissenkung in:
<span class="remaining"></span>.</p>

<p>Aktueller Preis: <?php echo $price; ?> EUR.</p>

<p><?php echo CHtml::link(
    'jetzt kaufen',
    '#',
    array(
        'submit' => array(
            'prebuy',
            'id' => $model->id,
        ),
        'csrf' => TRUE,
        'target' => '_top',
    )
); ?></p>
