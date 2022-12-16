<?php

/**
 * This is the model class for table "tbl_domain".
 *
 * The followings are the available columns in table 'tbl_domain':
 * @property integer $id
 * @property string $name
 * @property integer $initiator
 * @property integer $sold
 * @property integer $auction
 * @property string $auction_begin
 * @property string $verification_code
 * @property integer $auction_duration
 * @property integer $cpc_override
 * @property integer $auction_start_price
 * @property integer $auction_price_step
 * @property integer $contact_tab_enabled
 * @property integer $information_tab_enabled
 */
class TblDomain extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_domain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array(
				'auction, auction_start_price, auction_price_step, initiator, sold, auction_duration',
				'numerical',
				'integerOnly' => true,
				'min' => 0,
			),
			array(
				'cpc_override',
				'numerical',
				'integerOnly' => true,
				'min' => -1
			),
			array(
				'auction',
				'default',
				'setOnEmpty' => true,
				'value' => 0,
			),
			array(
				'contact_tab_enabled',
				'default',
				'setOnEmpty' => true,
				'value' => 0,
			),
			array(
				'information_tab_enabled',
				'default',
				'setOnEmpty' => true,
				'value' => 0,
			),
			array('name', 'unique', 'except' => 'search'),
			array('verification_code', 'length', 'max'=>16),
			array('name', 'length', 'max'=>255),
			array('auction_begin', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, auction, auction_begin, auction_start_price, auction_price_step', 'safe', 'on'=>'search'),
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
			'name' => Yii::t(
				'models',
				'Name'
			),
			'auction' => Yii::t(
				'models',
				'Auktion aktiv'
			),
			'auction_begin' => Yii::t(
				'models',
				'Auktionsbeginn'
			),
			'auction_start_price' => Yii::t(
				'models',
				'Startpreis (EUR)'
			),
			'auction_price_step' => Yii::t(
				'models',
				'Preisschritt (EUR)'
			),
			'auction_duration' => Yii::t(
				'models',
				'Auktionsdauer (Tage)'
			),
			'cpc_override' => Yii::t(
				'models',
				'CPC-Override (EUR-Cent)'
			),
			'initiator' => Yii::t(
				'models',
				'Erstinteressent'
			),
			'verification_code' => Yii::t(
				'models',
				'SMS-Bestaetigungscode'
			),
			'sold' => Yii::t(
				'models',
				'verkauft'
			),
			'contact_tab_enabled' => Yii::t(
				'models',
				'Kontakt-Reiter'
			),
			'information_tab_enabled' => Yii::t(
				'models',
				'Info-Reiter'
			),
		);
	}

	/**
	 * @return integer computed domain price in EUR
	 */
	public function computed_price()
	{
		$connection = Yii::app(
		)->db;
		if (
			0 > $this->cpc_override
		) {
			$keyword = substr(
				$this->name,
				0,
				strrpos(
					$this->name,
					"."
				)
			);
			$lookup_command = $connection->createCommand(
				"SELECT cents
    FROM tbl_keyword_cpc
    WHERE keyword=:keyword"
			);
			$lookup_command->bindParam(
				":keyword",
				$keyword
			);
			$dataReader = $lookup_command->query(
			);
			$row = $dataReader->read(
			);
			if (
				FALSE === $row
			) {
				return Yii::app(
				)->params[
					'maximumPrice'
				];
			}
			$cents = intval(
				$row[
					"cents"
				]
			);
		} else {
			$cents = $this->cpc_override;
		}
		$lookup_command = $connection->createCommand(
			"SELECT days,accesses
    FROM tbl_typein_sums
    WHERE domain=:id"
		);
		$id = $this->id;
		$lookup_command->bindParam(
			":id",
			$id
		);
		$dataReader = $lookup_command->query(
		);
		$row = $dataReader->read(
		);
		if (
			FALSE === $row
		) {
			return Yii::app(
			)->params[
				'maximumPrice'
			];
		}
		$days = $row[
			'days'
		];
		$accesses = $row[
			'accesses'
		];
		$by_year = $accesses * 365 / $days;
		$raw_value = $cents * $by_year * 100;
		if (
			$raw_value < Yii::app(
			)->params[
				'minimumPrice'
			]
		) {
			$raw_value = Yii::app(
			)->params[
				'minimumPrice'
			];
		}
		if (
			$raw_value > Yii::app(
			)->params[
				'maximumPrice'
			]
		) {
			$raw_value = Yii::app(
			)->params[
				'maximumPrice'
			];
		}
		return $raw_value;
	}

	public function auction_possible(
	) {
		return !$this->auction && (
			null == $this->sold
		);
	}

	public function get_auction_duration(
	) {
		return $this->auction_duration;
	}

	public function lowest_price(
	) {
		return $this->auction_start_price - $this->get_auction_duration(
		) * $this->auction_price_step;
	}

	public function get_auction_elapsed_days(
	) {
		return Yii::app(
		)->Date->daysCount(
			Yii::app(
			)->Date->now(
			),
			$this->auction_begin
		);
	}

	public function get_current_price(
	) {
		$computed = $this->auction_start_price - $this->get_auction_elapsed_days(
		) * $this->auction_price_step;
		$lowest = $this->lowest_price(
		);
		if (
			$lowest <= $computed
		) {
			return $computed;
		} else {
			return $lowest;
		}
	}

	public function process_priority_buying(
	) {
		if (
			1 != $this->auction
		) {
			return;
		}
		if (
			$this->get_current_price(
			) <= $this->lowest_price(
			)
		) {
			$this->auction = 0;
			
			$sale = new TblSale;
			$sale->domain = $this->id;
			$sale->price = $this->lowest_price(
			);
			$sale->sold_at = Yii::app(
			)->Date->now(
			);
			$sale->buyer = $this->initiator;
			if (
				!$sale->save(
				)
			) {
				foreach (
					$sale->getErrors(
					) as $slot => $messages
				) {
					foreach (
						$messages as $message
					) {
						throw new CDbException(
							"$slot: $message"
						);
					}
				}
			}
			$this->auction = 0;
			$this->sold = $sale->id;
			if (
				!$this->save(
				)
			) {
				foreach (
					$this->getErrors(
					) as $slot => $messages
				) {
					foreach (
						$messages as $message
					) {
						throw new CDbException(
							"$slot: $message"
						);
					}
				}
			} 
			Yii::app(
			)->mailer->Host = '127.0.0.1';
			Yii::app(
			)->mailer->IsSMTP(
			);
			Yii::app(
			)->mailer->From = Yii::app()->params[
				'systemEmail'
			];
			Yii::app(
			)->mailer->FromName = Yii::app(
			)->name;
			Yii::app(
			)->mailer->AddReplyTo(
				Yii::app(
				)->params[
					'systemEmail'
				]
			);
			$initiator=User::model()->findByPk($this->initiator);
			if($initiator===null)
				throw new CDbException('User does not exist.');
			Yii::app(
			)->mailer->AddAddress(
				 $initiator->email
			);
			Yii::app(
			)->mailer->Subject = "Domain gekauft";
			Yii::app(
			)->mailer->Body = "Sehr " . (
				(
					"Frau" == $initiator->title
				) ? "geehrte" : "geehrter"
			) . " " . $initiator->title . " " . $initiator->lastname . ",

Sie haben soeben die Domain " . $this->name . " gekauft, da kein Bieter
bereit war, einen hoeheren Preis zu bezahlen.";
			Yii::app(
			)->mailer->Send(
			);
		}
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('auction',$this->auction);
		$criteria->compare('auction_begin',$this->auction_begin,true);
		$criteria->compare('initiator',$this->initiator);
		$criteria->compare('sold',$this->sold);
		$criteria->compare('auction_start_price',$this->auction_start_price);
		$criteria->compare('auction_price_step',$this->auction_price_step);
		$criteria->compare('contact_tab_enabled',$this->contact_tab_enabled);
		$criteria->compare('information_tab_enabled',$this->information_tab_enabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TblDomain the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
