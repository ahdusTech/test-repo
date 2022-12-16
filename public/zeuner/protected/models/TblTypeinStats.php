<?php

/**
 * This is the model class for table "tbl_typein_stats".
 *
 * The followings are the available columns in table 'tbl_typein_stats':
 * @property integer $domain
 * @property string $access_date
 * @property integer $accesses
 * @property string $counted_on
 *
 * The followings are the available model relations:
 * @property TblDomain $domain0
 */
class TblTypeinStats extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_typein_stats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('domain, counted_on', 'required'),
			array('domain, accesses', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('domain, access_date, accesses, counted_on', 'safe', 'on'=>'search'),
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
			'access_date' => 'Access Date',
			'accesses' => 'Accesses',
			'counted_on' => 'Counted On',
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
		$criteria->compare('access_date',$this->access_date,true);
		$criteria->compare('accesses',$this->accesses);
		$criteria->compare('counted_on',$this->counted_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblTypeinStats the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
