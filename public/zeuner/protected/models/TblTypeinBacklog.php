<?php

/**
 * This is the model class for table "tbl_typein_backlog".
 *
 * The followings are the available columns in table 'tbl_typein_backlog':
 * @property integer $domain
 * @property string $aggregated_on
 * @property integer $backlog0
 * @property integer $backlog1
 * @property integer $backlog2
 * @property integer $backlog3
 * @property integer $backlog4
 * @property integer $backlog5
 * @property integer $backlog6
 * @property integer $backlog7
 * @property integer $backlog8
 * @property integer $backlog9
 *
 * The followings are the available model relations:
 * @property TblDomain $domain0
 */
class TblTypeinBacklog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_typein_backlog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('aggregated_on', 'required'),
			array('backlog0, backlog1, backlog2, backlog3, backlog4, backlog5, backlog6, backlog7, backlog8, backlog9', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('domain, aggregated_on, backlog0, backlog1, backlog2, backlog3, backlog4, backlog5, backlog6, backlog7, backlog8, backlog9', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'domain0' => array(self::BELONGS_TO, 'TblDomain', 'domain'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'domain' => 'Domain',
			'aggregated_on' => 'Aggregated On',
			'backlog0' => 'Backlog0',
			'backlog1' => 'Backlog1',
			'backlog2' => 'Backlog2',
			'backlog3' => 'Backlog3',
			'backlog4' => 'Backlog4',
			'backlog5' => 'Backlog5',
			'backlog6' => 'Backlog6',
			'backlog7' => 'Backlog7',
			'backlog8' => 'Backlog8',
			'backlog9' => 'Backlog9',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('domain',$this->domain);
		$criteria->compare('aggregated_on',$this->aggregated_on,true);
		$criteria->compare('backlog0',$this->backlog0);
		$criteria->compare('backlog1',$this->backlog1);
		$criteria->compare('backlog2',$this->backlog2);
		$criteria->compare('backlog3',$this->backlog3);
		$criteria->compare('backlog4',$this->backlog4);
		$criteria->compare('backlog5',$this->backlog5);
		$criteria->compare('backlog6',$this->backlog6);
		$criteria->compare('backlog7',$this->backlog7);
		$criteria->compare('backlog8',$this->backlog8);
		$criteria->compare('backlog9',$this->backlog9);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblTypeinBacklog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
