<?php
/* @var $this  SiteController
   @var $model TblDomain
   @var $now   string
   @var $price integer
*/

$this->pageTitle=$model->name;
?>

<h1><i><?php echo CHtml::encode($model->name); ?></i> is for sale!</h1>

<p>Next price decrease in:
<span class="remaining"></span>.</p>

<p>Current price: <?php echo $price; ?> EUR.</p>

<p><?php echo CHtml::link(
    'buy now',
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
