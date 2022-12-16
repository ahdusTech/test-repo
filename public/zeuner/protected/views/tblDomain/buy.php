<?php
/* @var $this  TblDomainController
   @var $model TblDomain
   @var $price integer
*/

$this->pageTitle=$model->name;
?>

<h1><i><?php echo CHtml::encode($model->name); ?></i> kaufen</h1>

<p>Wenn Sie fortfahren, verpflichten Sie sich, die Domain
<i><?php echo CHtml::encode($model->name); ?></i> zum Preis von
<?php echo $price; ?> EUR zu kaufen.</p>
<p><?php echo CHtml::link('Fortfahren',
    '#',
    array(
        'submit' => array(
            'buy',
            'id' => $model->id,
        ),
        'params' => array(
            'price' => $price
        ),
        'csrf' => TRUE,
    )
); ?></p>
<p><?php echo CHtml::link('Zur&uuml;ck zum Status', array('status', 'id' => $model->id)); ?></p>

