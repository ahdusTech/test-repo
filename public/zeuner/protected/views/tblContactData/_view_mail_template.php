<?php
/* @var $this TblContactDataController */
/* @var $data TblMailTemplate */
/* @var $contact_data TblContactData */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::link(
    CHtml::encode(
        $data->title
    ),
    '#',
    array(
        'submit' => array(
            'finish_mail',
            'id' => $contact_data->id,
        ),
        'params' => array(
            'template' => $data->id,
        ),
        'csrf' => TRUE,
    )
); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />


</div>
