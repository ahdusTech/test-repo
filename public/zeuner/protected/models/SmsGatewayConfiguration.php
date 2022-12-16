<?php

class SmsGatewayConfiguration extends FileBasedPersistentModel
{
	public function __construct(
		$scenario='insert'
	) {
		parent::__construct(
			dirname(
				__FILE__
			) . '/../config/introspectable',
			'sms_gateway.php',
			$scenario
		);
	}

	public function attributeNames()
	{
		return array(
			'sms_gateway',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model(
			$className
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(
				'sms_gateway',
				'required',
			),
			array(
				'sms_gateway',
				'numerical',
				'integerOnly' => true,
				'min' => 1,
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sms_gateway' => Yii::t('models', 'SMS-Gateway'),
		);
	}

	/**
	 * PHP getter magic method.
	 * This method is overridden so that configuration attributes can be accessed like properties.
	 * @param string $name property name
	 * @return mixed property value
	 * @see getAttribute
	 */
	public function __get($name)
	{
		if (
			'sms_gateway' == $name
		) {
			$configuration = $this->get_data(
			);
			$class_map = array(
				'application.components.BulkSMSGate' => 1,
				'application.components.HetznerSMSGate' => 2,
			);
			if (
				!isset(
					$class_map[
						$configuration[
							'class'
						]
					]
				)
			) {
				throw new CException(
					'unknown sms gateway'
				);
			}
			return $class_map[
				$configuration[
					'class'
				]
			];
		} else
			return parent::__get($name);
	}

	/**
	 * PHP setter magic method.
	 * This method is overridden so that configuration attributes can be accessed like properties.
	 * @param string $name property name
	 * @param mixed $value property value
	 */
	public function __set($name,$value)
	{
		if (
			'sms_gateway' == $name
		) {
			$file_map = array(
				1 => 'bulksms',
				2 => 'hetzner',
			);
			if (
				!isset(
					$file_map[
						$value
					]
				)
			) {
				throw new CException(
					'invalid value for sms configuration'
				);
			}
			$this->set_by_file(
				dirname(
					__FILE__
				) . '/../config/sms_gateway.' . $file_map[
					$value
				] . '.php'
			);
		} else
			parent::__set($name,$value);
	}

	/**
	 * Checks if a property value is null.
	 * This method overrides the parent implementation by checking
	 * if the named attribute is null or not.
	 * @param string $name the property name or the event name
	 * @return boolean whether the property value is null
	 */
	public function __isset($name)
	{
		if (
			'sms_gateway' == $name
		) {
			return true;
		} else
			return parent::__isset($name);
	}

	/**
	 * Sets a component property to be null.
	 * This method overrides the parent implementation by clearing
	 * the specified attribute value.
	 * @param string $name the property name or the event name
	 */
	public function __unset($name)
	{
		if (
			'sms_gateway' == $name
		) {
			throw new CException(
				'sms configuration cannot be null'
			);
		} else
			parent::__unset($name);
	}

	public function save()
	{
	}

}
