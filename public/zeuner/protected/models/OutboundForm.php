<?php

/**
 * OutboundForm class.
 * OutboundForm is the data structure for keeping
 * outbound contact form data. It is used by the 'finish_mail' action of 'TblContactDataController'.
 */
class OutboundForm extends CFormModel
{
	public $subject;
	public $body;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// subject is required
			array('subject', 'required'),
			// body is required
			array('body', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'subject'=>'Betreff',
			'body'=>'Text',
		);
	}
}
