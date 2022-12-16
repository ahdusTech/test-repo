<?php

class ParamConfiguration extends FileBasedPersistentModel
{
	private $data;

	public function __construct(
		$scenario='insert'
	) {
		parent::__construct(
			dirname(
				__FILE__
			) . '/../config/introspectable',
			'params.php',
			$scenario
		);
		$data = FALSE;
	}

	public function attributeNames()
	{
		return array(
			'systemEmail',
			'adminEmail',
			'minimumPrice',
			'maximumPrice',
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
				'systemEmail, adminEmail, minimumPrice, maximumPrice',
				'required',
			),
			array(
				'minimumPrice, maximumPrice',
				'numerical',
				'integerOnly' => 1,
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'systemEmail' => Yii::t(
				'models',
				'Absenderadresse fuer Systemmitteilungen'
			),
			'adminEmail' => Yii::t(
				'models',
				'Empfaengeradresse des Betreibers'
			),
			'minimumPrice' => Yii::t(
				'models',
				'Mindestpreis fuer Preisberechnung'
			),
			'maximumPrice' => Yii::t(
				'models',
				'Hoechstpreis fuer Preisberechnung'
			),
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
			FALSE !== array_search(
				$name,
				$this->attributeNames(
				)
			)
		) {
			if (
				!is_array(
					$this->data
				)
			) {
				$this->data = $this->get_data(
				);
			}
			return $this->data[
				$name
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
			FALSE !== array_search(
				$name,
				$this->attributeNames(
				)
			)
		) {
			if (
				!is_array(
					$this->data
				)
			) {
				$this->data = $this->get_data(
				);
			}
			$this->data[
				$name
			] = $value;
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
			FALSE !== array_search(
				$name,
				$this->attributeNames(
				)
			)
		) {
			return TRUE;
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
			FALSE !== array_search(
				$name,
				$this->attributeNames(
				)
			)
		) {
			throw new CException(
				$name . ' cannot be null'
			);
		} else
			parent::__unset($name);
	}

	public function save()
	{
		$data = "<?php

return array(
";
		foreach (
			$this->data as $key => $value
		) {
			$data .= "	'" . str_replace(
				"'",
				"' . \"'\" . '",
				preg_replace(
					"/[^a-zA-Z0-9_@.]'\"/",
					"",
					$key
				)
			) . "' => ";
			if (
				is_string(
					$value
				)
			) {
				$data .= "'" . str_replace(
					"'",
					"' . \"'\" . '",
					preg_replace(
						"/[^a-zA-Z0-9_@.]'\"/",
						"",
						$value
					)
				) . "'";
			} else if (
				is_numeric(
					$value
				)
			) {
				$data .= $value;
			} else {
				$data .= "FALSE";
			}
			$data .= ",
";
		}
		$data .= ");
";
		$this->set_by_string(
			$data
		);
	}

}
