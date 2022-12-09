<?php

/**
 * This is the model class for table "tbl_sale".
 *
 * The followings are the available columns in table 'tbl_sale':
 * @property integer $id
 * @property integer $domain
 * @property integer $buyer
 * @property integer $price
 *
 * The followings are the available model relations:
 * @property UsrUsers $buyer0
 * @property TblDomain $domain0
 */
class TblSale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sale';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('domain, buyer, sold_at', 'required'),
			array('domain, buyer, price', 'numerical', 'integerOnly'=>true),
			array(
				'paid',
				'default',
				'setOnEmpty' => true,
				'value' => 0
			),
			array('domain', 'unique', 'except' => 'search'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, domain, buyer, price', 'safe', 'on'=>'search'),
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
			'buyer0' => array(self::BELONGS_TO, 'UsrUsers', 'buyer'),
			'domain0' => array(self::BELONGS_TO, 'TblDomain', 'domain'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('models', 'ID'),
			'domain' => Yii::t('models', 'Domain'),
			'buyer' => Yii::t('models', 'Kaeufer'),
			'sold_at' => Yii::t('models', 'Verkaufszeitpunkt'),
			'price' => Yii::t('models', 'Kaufpreis (EUR)'),
			'paid' => Yii::t('models', 'bezahlt'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('domain',$this->domain);
		$criteria->compare('buyer',$this->buyer);
		$criteria->compare('sold_at',$this->sold_at);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblSale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
