<?php

/**
 * This is the model class for table "tbl_mail_template".
 *
 * The followings are the available columns in table 'tbl_mail_template':
 * @property integer $id
 * @property string $title
 * @property string $subject
 * @property string $content
 * @property integer $last_change
 */
class TblMailTemplate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_mail_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('last_change', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('subject', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, subject, content, last_change', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t(
				'models',
				'ID'
			),
			'title' => Yii::t(
				'model',
				'Name der Vorlage'
			),
			'subject' => Yii::t(
				'model',
				'Mail-Betreff'
			),
			'content' => Yii::t(
				'models',
				'Mail-Inhalt'
			),
			'last_change' => Yii::t(
				'models',
				'Letzte Aenderung (Unix-Zeitstempel)'
			),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('last_change',$this->last_change);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblMailTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
