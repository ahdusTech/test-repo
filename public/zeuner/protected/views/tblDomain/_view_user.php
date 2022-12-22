<?php
/* @var $this TblDomainController */
/* @var $data User */
/* @var $domain tblDomain */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(
    CHtml::encode(
        $data->id
    ),
    '#',
    array(
        'submit' => array(
            'offer',
            'id' => $domain->id,
        ),
        'params' => array(
            'user' => $data->id,
        ),
        'csrf' => TRUE,
    )
); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_name')); ?>:</b>
	<?php echo CHtml::encode($data->company_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
	<?php echo CHtml::encode($data->firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
	<?php echo CHtml::encode($data->lastname); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_on')); ?>:</b>
	<?php echo CHtml::encode($data->created_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_on')); ?>:</b>
	<?php echo CHtml::encode($data->updated_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_visit_on')); ?>:</b>
	<?php echo CHtml::encode($data->last_visit_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password_set_on')); ?>:</b>
	<?php echo CHtml::encode($data->password_set_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_verified')); ?>:</b>
	<?php echo CHtml::encode($data->email_verified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_verification_required')); ?>:</b>
	<?php echo CHtml::encode($data->sms_verification_required); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_disabled')); ?>:</b>
	<?php echo CHtml::encode($data->is_disabled); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('one_time_password_secret')); ?>:</b>
	<?php echo CHtml::encode($data->one_time_password_secret); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('one_time_password_code')); ?>:</b>
	<?php echo CHtml::encode($data->one_time_password_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('one_time_password_counter')); ?>:</b>
	<?php echo CHtml::encode($data->one_time_password_counter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zipcode')); ?>:</b>
	<?php echo CHtml::encode($data->zipcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vat_id')); ?>:</b>
	<?php echo CHtml::encode($data->vat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	*/ ?>

</div>
