<?php
/**
 * GenericPersistentModel class file.
 *
 * @author Isidor Zeuner <yii@quidecco.de>
 * @link http://quidecco.de/
 * @copyright 2016 Isidor Zeuner
 * @license http://www.yiiframework.com/license/
 */

abstract class GenericPersistentModel extends CModel
{
	public $id;
	public $isNewRecord;
	private $criteria;
	private static $models;
	private $instance;
	private $class_name;
	/**
	 * Constructor.
	 * @param string $scenario scenario name. See {@link CModel::scenario} for more details about this parameter.
	 * Note: in order to setup initial model parameters use {@link init()} or {@link afterConstruct()}.
	 * Do NOT override the constructor unless it is absolutely necessary!
	 */
	public function __construct($scenario='insert')
	{
		if($scenario===null) // internally used by populateRecord() and model()
			return;

		$this->criteria = null;

		$this->setScenario($scenario);

		$this->init();

		$this->attachBehaviors($this->behaviors());
		$this->afterConstruct();
	}

	/**
	 * Initializes this model.
	 * This method is invoked when an AR instance is newly created and has
	 * its {@link scenario} set.
	 * You may override this method to provide code that is needed to initialize the model (e.g. setting
	 * initial property values.)
	 */
	public function init()
	{
	}

	/**
	 * PHP sleep magic method.
	 * This method ensures that the model meta data reference is set to null.
	 * @return array
	 */
	public function __sleep()
	{
		return $this->attributeNames(
		);
	}

	public function getDbCriteria($createIfNull=true)
	{
		if (
			null === $this->criteria
		) {
			$this->criteria = new CDbCriteria;
		}
		return $this->criteria;
	}

	public function setDbCriteria($criteria)
	{
		$this->criteria = $criteria;
	}

	public function count($condition='',$params=array())
	{
		return 1;
	}

	public function findAll($condition='',$params=array())
	{
		return array(
			new $this->class_name
		);
	}

	public function getPrimaryKey()
	{
		return array(
			'id' => 1,
		);
	}

	public static function model($className=__CLASS__)
	{
		if (
			isset(
				self::$models[
					$className
				]
			)
		) {
			return self::$models[
				$className
			];
		} else {
			$model = self::$models[
				$className
			] = new $className(
				null
			);
			$model->class_name = $className;
			$model->attachBehaviors(
				$model->behaviors(
				)
			);
			return $model;
		}
	}

	public function findByPk($id)
	{
		if (
			1 != $id
		) {
			throw new CException(
				'nonexistant instance'
			);
		}
		if (
			isset(
				$this->instance
			)
		) {
			return $this->instance;
		} else {
			$instance = $this->instance = new $this->class_name(
				null
			);
			$instance->id = $id;
			$instance->class_name = $this->class_name;
			$instance->attachBehaviors(
				$this->behaviors(
				)
			);
			return $instance;
		}
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
			'attributes' == $name
		) {
			foreach (
				$value as $sub_name => $sub_value
			) {
				$this->__set(
					$sub_name,
					$sub_value
				);
			}
		} else
			parent::__set($name,$value);
	}
}
