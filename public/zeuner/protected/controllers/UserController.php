<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array(
					'register',
					'verify',
					'enable'
				),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform CRUD actions
				'actions'=>array(
					'admin_enable',
					'index',
					'index_disabled',
					'view',
					'create',
					'update',
					'admin',
					'delete',
				),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Checks user enabling
	 * @param integer $id the ID of the user model to be displayed
	 */
	public function actionEnable($id)
	{
		$model = $this->loadModel($id);
		if (
			0 == $model->is_disabled
		) {
			$this->redirect(
				array(
					'TblDomain/index_auctions',
				)
			);
			return;
		}
		if (
			null == $model->verification_code
		) {
			$model->verification_code = str_replace(
				'~',
				'',
				Yii::app(
				)->getSecurityManager(
				)->generateRandomString(
					6
				)
			);
			$result = Yii::app(
			)->smsGateway->send(
				$model->phone,
				Yii::t(
					'app',
					'Bitte geben Sie den Code {code} ein,
um Ihre Registrierung zur {application_name} abzuschliessen.',
					array(
						'{code}' => $model->verification_code,
						'{application_name}' => Yii::app(
						)->name,
					)
				)
			);
			if (
				1 != $result[
					'success'
				]
			) {
				Yii::log(
					'SMS sending failed: ' . $result[
						'details'
					],
					CLogger::LEVEL_ERROR
				);
				throw new CHttpException(
					500,
					Yii::t(
						'app',
						'SMS fehlgeschlagen'
					)
				);
			}
			$model->terms_agreed = TRUE;
			if (
				!$model->save(
				)
			) {
				foreach (
					$model->getErrors(
					) as $slot => $messages
				) {
					foreach (
						$messages as $message
					) {
						throw new CHttpException(
							500,
							"$slot: $message"
						);
					}
				}
			}
		}
		$entered_verification_code = Yii::app( 
		)->request->getParam(
			'verification_code'
		);
		if (    
			$entered_verification_code != $model->verification_code
		) {
			if (
				NULL !== $entered_verification_code
			) {
				Yii::app(
				)->user->setFlash(
					'verification',
					Yii::t(
						'app',
						'Der von Ihnen eingegebene Bestaetigungscode ist falsch!'
					)
				);
			}
			$this->render(
				'enable',
				array(
					'model'=> $model
				)
			);      
			return; 
		}	       
		$model->is_disabled = 0;
		$model->terms_agreed = TRUE;
		if (
			!$model->save(
			)
		) {
			foreach (
				$model->getErrors(
				) as $slot => $messages
			) {
				foreach (
					$messages as $message
				) {
					throw new CHttpException(
						500,
						"$slot: $message"
					);
				}
			}
		}
		Yii::app(
		)->mailer->IsSMTP(
		);
		Yii::app(
		)->mailer->From = Yii::app(
		)->params[
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
		Yii::app(
		)->mailer->AddAddress(
			Yii::app(
			)->params[
				'adminEmail'
			]
		);
		Yii::app(
		)->mailer->Subject = "Neuer Kunde registriert";
		Yii::app(
		)->mailer->Body = "Sehr geehrte Damen und Herren,

soeben hat sich ein neuer Kunde erfolgreich registriert.

Details:

Benutzername: " . $model->username . "
Name: " . $model->title . " " . $model->firstname . " " . $model->lastname . "
Firma: " . $model->company_name . "
Mobil: " . $model->phone . "
E-Mail: " . $model->email . "
Adresse: " . $model->street . "
Postleitzahl/Ort: " . $model->zipcode . " " . $model->city . "
Land: " . $model->country . "

Sie koennen unter
folgendem Link die Daten einsehen:

" . Yii::app(
		)->createAbsoluteUrl(
			'User/view',
			array(
				'id' => $model->id,
			)
		);
		Yii::app(
		)->mailer->Send(
		);
		Yii::app(
		)->user->setFlash(
			'login',
			Yii::t(
				'app',
				'Registrierung erfolgreich. Sie koennen sich
jetzt einloggen.'
			)
		);
		$this->redirect(
			array(
				'site/login',
			)
		);
	}

	/**
	 * Checks user email verification and sends confirmation mail if required
	 * @param integer $id the ID of the user model to be displayed
	 */
	public function actionVerify($id)
	{
		$model = $this->loadModel($id);
		$identity = UserIdentity::find(
			array(
				'id' => $model->id,
			)
		);
		if (
			$identity === null
		) {
			throw new CHttpException(
				404,
				Yii::t(
					'app',
					'Seite nicht gefunden.'
				)
			);
		}
		if (
			isset(
				$_GET[
					"key"
				]
			)
		) {
			if (
				UserIdentity::ERROR_AKEY_NONE === (
					$identity->verifyActivationKey(
						$_GET[
							"key"
						]
					)
				)
			) {
				$model->email_verified = 1;
				$model->is_active = 1;
				$model->terms_agreed = TRUE;
				if (
					!$model->save(
					)
				) {
					foreach (
						$model->getErrors(
						) as $slot => $messages
					) {
						foreach (
							$messages as $message
						) {
							throw new CHttpException(
								500,
								"$slot: $message"
							);
						}
					}
				}
			}
		}
		if (
			1 == $model->email_verified
		) {
			$this->redirect(
				array(
					'User/enable',
					'id' => $model->id,
				)
			);
			return;
		}
		$key = $identity->getActivationKey(
		);
		if (
			false === $key
		) {
			throw new CHttpException(
				500,
				Yii::t(
					'app',
					'Kann keinen Aktivierungscode erzeugen.'
				)
			);
		}
		Yii::app(
		)->mailer->IsSMTP(
		);
		Yii::app(
		)->mailer->From = Yii::app(
		)->params[
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
		Yii::app(
		)->mailer->AddAddress(
			 $model->email
		);
		Yii::app(
		)->mailer->Subject = Yii::t(
			'app',
			"Aktivierung Ihrer Registrierung"
		);
		Yii::app(
		)->mailer->Body = Yii::t(
			'app',
			(
				"Frau" == $model->title
			) ? 'Sehr geehrte Frau {last_name}' : 'Sehr geehrter Herr {last_name}',
			array(
				'{last_name}' => $model->lastname,
			)
		) . ",

" . Yii::t(
			'app',
			'damit Ihre Registrierung abgeschlossen werden kann,
klicken Sie bitte auf folgenden Link, um Ihre E-Mail-Adresse zu verifizieren:

{verify_url}',
			array(
				'{verify_url}' => Yii::app(
				)->createAbsoluteUrl(
					'User/verify',
					array(
						'id' => $model->id,
						'key' => $key,
					)
				)
			)
		);
		Yii::app(
		)->mailer->Send(
		);
		$this->pageTitle = Yii::t(
			'app',
			'Aktivierungs-Mail versandt'
		);
		$this->render(
			'message',
			array(
				'model' => $model,
				'message' => Yii::t(
					'app',
					"Bitte sehen Sie im von Ihnen
angegebenen E-Mail-Postfach nach. Dorthin wurde soeben eine Aktivierungs-Mail
versandt. Bitte oeffnen Sie den Link in Ihrer Aktivierungs-Mail, um mit der
Registrierung fortzufahren."
				),
			)
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Registers a new user
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRegister()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->sms_verification_required = 0;
			$model->email_verified = 0;
			$model->is_active = 0;
			$model->is_disabled = 1;
			if($model->save())
				$this->redirect(
					array(
						'verify',
						'id' => $model->id
					)
				);
		}

		$model->password_plain = '';
		$model->password_again = '';
		$this->render('register',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$model->password_plain = '';
		$model->password_again = '';
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$model->password_plain = '';
		$model->password_again = '';
		$model->terms_agreed = TRUE;
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Enables a user
	 * If enabling is successful, the browser will be redirected to 'view' page for the user.
	 * @param integer $id the ID of the user model to be enabled
	 */
	public function actionAdmin_enable($id)
	{
		$model = $this->loadModel(
			$id
		);
		$model->is_disabled = 0;
		$model->save(
		);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $id));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all models pending enabling.
	 */
	public function actionIndex_disabled()
	{
		$model = new User(
			'search'
		);
		$model->unsetAttributes(
		);  // clear any default values
		$attributes = array(
			'is_active' => 1,
			'is_disabled' => 1,
		);
		$model->attributes = $attributes;
		$dataProvider = $model->search(
		);
		$this->render('index_disabled',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(
				404,
				Yii::t(
					'app',
					'Seite nicht gefunden.'
				)
			);
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Provides a translated country list
	 */
	public function get_countries()
	{
		$result = array(
		);
		foreach (
			$this->countries as $key => $value
		) {
			$result[
				$key
			] = Yii::t(
				'app',
				$value
			);
		}
		return $result;
	}

	/**
	 * @var array country list
	 */
	private $countries = array(
		'' => 'Bitte auswaehlen',
		'Deutschland' => 'Deutschland',
		'Österreich' => 'Österreich',
		'Schweiz (Confoederatio Helvetica)' => 'Schweiz (Confoederatio Helvetica)',
		'Afghanistan' => 'Afghanistan',
		'Ägypten' => 'Ägypten',
		'Albanien' => 'Albanien',
		'Algerien' => 'Algerien',
		'Amerikanisch-Samoa' => 'Amerikanisch-Samoa',
		'Amerikanische Jungferninseln' => 'Amerikanische Jungferninseln',
		'Andorra' => 'Andorra',
		'Angola' => 'Angola',
		'Anguilla' => 'Anguilla',
		'Antarktika (Sonderstatus durch Antarktis-Vertrag )' => 'Antarktika (Sonderstatus durch Antarktis-Vertrag )',
		'Antigua und Barbuda' => 'Antigua und Barbuda',
		'Äquatorialguinea' => 'Äquatorialguinea',
		'Argentinien' => 'Argentinien',
		'Armenien' => 'Armenien',
		'Aruba' => 'Aruba',
		'Aserbaidschan' => 'Aserbaidschan',
		'Äthiopien' => 'Äthiopien',
		'Australien' => 'Australien',
		'Bahamas' => 'Bahamas',
		'Bahrain' => 'Bahrain',
		'Bangladesch' => 'Bangladesch',
		'Barbados' => 'Barbados',
		'Belarus (Weißrussland)' => 'Belarus (Weißrussland)',
		'Belgien' => 'Belgien',
		'Belize' => 'Belize',
		'Benin' => 'Benin',
		'Bermuda' => 'Bermuda',
		'Bhutan' => 'Bhutan',
		'Bolivien' => 'Bolivien',
		'Bonaire, Sint Eustatius und Saba (Niederlande)' => 'Bonaire, Sint Eustatius und Saba (Niederlande)',
		'Bosnien und Herzegowina' => 'Bosnien und Herzegowina',
		'Botswana' => 'Botswana',
		'Bouvetinsel' => 'Bouvetinsel',
		'Brasilien' => 'Brasilien',
		'Britische Jungferninseln' => 'Britische Jungferninseln',
		'Britisches Territorium im Indischen Ozean' => 'Britisches Territorium im Indischen Ozean',
		'Brunei Darussalam' => 'Brunei Darussalam',
		'Bulgarien' => 'Bulgarien',
		'Burkina Faso' => 'Burkina Faso',
		'Burundi' => 'Burundi',
		'Chile' => 'Chile',
		'China, Volksrepublik' => 'China, Volksrepublik',
		'Cookinseln' => 'Cookinseln',
		'Costa Rica' => 'Costa Rica',
		'Côte d’Ivoire (Elfenbeinküste)' => 'Côte d’Ivoire (Elfenbeinküste)',
		'Curaçao' => 'Curaçao',
		'Dänemark' => 'Dänemark',
		'Dominica' => 'Dominica',
		'Dominikanische Republik' => 'Dominikanische Republik',
		'Dschibuti' => 'Dschibuti',
		'Ecuador' => 'Ecuador',
		'El Salvador' => 'El Salvador',
		'Eritrea' => 'Eritrea',
		'Estland' => 'Estland',
		'Falklandinseln' => 'Falklandinseln',
		'Färöer' => 'Färöer',
		'Fidschi' => 'Fidschi',
		'Finnland' => 'Finnland',
		'Frankreich' => 'Frankreich',
		'Französisch-Guayana' => 'Französisch-Guayana',
		'Französisch-Polynesien' => 'Französisch-Polynesien',
		'Französische Süd- und Antarktisgebiete' => 'Französische Süd- und Antarktisgebiete',
		'Gabun' => 'Gabun',
		'Gambia' => 'Gambia',
		'Georgien' => 'Georgien',
		'Ghana' => 'Ghana',
		'Gibraltar' => 'Gibraltar',
		'Grenada' => 'Grenada',
		'Griechenland' => 'Griechenland',
		'Grönland' => 'Grönland',
		'Guadeloupe' => 'Guadeloupe',
		'Guam' => 'Guam',
		'Guatemala' => 'Guatemala',
		'Guernsey (Kanalinsel)' => 'Guernsey (Kanalinsel)',
		'Guinea' => 'Guinea',
		'Guinea-Bissau' => 'Guinea-Bissau',
		'Guyana' => 'Guyana',
		'Haiti' => 'Haiti',
		'Heard und McDonaldinseln' => 'Heard und McDonaldinseln',
		'Honduras' => 'Honduras',
		'Hongkong' => 'Hongkong',
		'Indien' => 'Indien',
		'Indonesien' => 'Indonesien',
		'Insel Man' => 'Insel Man',
		'Irak' => 'Irak',
		'Iran, Islamische Republik' => 'Iran, Islamische Republik',
		'Irland' => 'Irland',
		'Island' => 'Island',
		'Israel' => 'Israel',
		'Italien' => 'Italien',
		'Jamaika' => 'Jamaika',
		'Japan' => 'Japan',
		'Jemen' => 'Jemen',
		'Jersey (Kanalinsel)' => 'Jersey (Kanalinsel)',
		'Jordanien' => 'Jordanien',
		'Kaimaninseln' => 'Kaimaninseln',
		'Kambodscha' => 'Kambodscha',
		'Kamerun' => 'Kamerun',
		'Kanada' => 'Kanada',
		'Kap Verde' => 'Kap Verde',
		'Kasachstan' => 'Kasachstan',
		'Katar' => 'Katar',
		'Kenia' => 'Kenia',
		'Kirgisistan' => 'Kirgisistan',
		'Kiribati' => 'Kiribati',
		'Kokosinseln' => 'Kokosinseln',
		'Kolumbien' => 'Kolumbien',
		'Komoren' => 'Komoren',
		'Kongo, Demokratische Republik (ehem. Zaire)' => 'Kongo, Demokratische Republik (ehem. Zaire)',
		'Republik Kongo' => 'Republik Kongo',
		'Korea, Demokratische Volksrepublik (Nordkorea)' => 'Korea, Demokratische Volksrepublik (Nordkorea)',
		'Korea, Republik (Südkorea)' => 'Korea, Republik (Südkorea)',
		'Kroatien' => 'Kroatien',
		'Kuba' => 'Kuba',
		'Kuwait' => 'Kuwait',
		'Laos, Demokratische Volksrepublik' => 'Laos, Demokratische Volksrepublik',
		'Lesotho' => 'Lesotho',
		'Lettland' => 'Lettland',
		'Libanon' => 'Libanon',
		'Liberia' => 'Liberia',
		'Libyen' => 'Libyen',
		'Liechtenstein' => 'Liechtenstein',
		'Litauen' => 'Litauen',
		'Luxemburg' => 'Luxemburg',
		'Macau' => 'Macau',
		'Madagaskar' => 'Madagaskar',
		'Malawi' => 'Malawi',
		'Malaysia' => 'Malaysia',
		'Malediven' => 'Malediven',
		'Mali' => 'Mali',
		'Malta' => 'Malta',
		'Marokko' => 'Marokko',
		'Marshallinseln' => 'Marshallinseln',
		'Martinique' => 'Martinique',
		'Mauretanien' => 'Mauretanien',
		'Mauritius' => 'Mauritius',
		'Mayotte' => 'Mayotte',
		'Mazedonien' => 'Mazedonien',
		'Mexiko' => 'Mexiko',
		'Mikronesien' => 'Mikronesien',
		'Moldawien (Republik Moldau)' => 'Moldawien (Republik Moldau)',
		'Monaco' => 'Monaco',
		'Mongolei' => 'Mongolei',
		'Montenegro' => 'Montenegro',
		'Montserrat' => 'Montserrat',
		'Mosambik' => 'Mosambik',
		'Myanmar (Burma)' => 'Myanmar (Burma)',
		'Namibia' => 'Namibia',
		'Nauru' => 'Nauru',
		'Nepal' => 'Nepal',
		'Neukaledonien' => 'Neukaledonien',
		'Neuseeland' => 'Neuseeland',
		'Nicaragua' => 'Nicaragua',
		'Niederlande' => 'Niederlande',
		'Niger' => 'Niger',
		'Nigeria' => 'Nigeria',
		'Niue' => 'Niue',
		'Nördliche Marianen' => 'Nördliche Marianen',
		'Norfolkinsel' => 'Norfolkinsel',
		'Norwegen' => 'Norwegen',
		'Oman' => 'Oman',
		'Osttimor (Timor-Leste)' => 'Osttimor (Timor-Leste)',
		'Pakistan' => 'Pakistan',
		'Staat Palästina [5]' => 'Staat Palästina [5]',
		'Palau' => 'Palau',
		'Panama' => 'Panama',
		'Papua-Neuguinea' => 'Papua-Neuguinea',
		'Paraguay' => 'Paraguay',
		'Peru' => 'Peru',
		'Philippinen' => 'Philippinen',
		'Pitcairninseln' => 'Pitcairninseln',
		'Polen' => 'Polen',
		'Portugal' => 'Portugal',
		'Puerto Rico' => 'Puerto Rico',
		'Réunion' => 'Réunion',
		'Ruanda' => 'Ruanda',
		'Rumänien' => 'Rumänien',
		'Russische Föderation' => 'Russische Föderation',
		'Salomonen' => 'Salomonen',
		'Saint-Barthélemy' => 'Saint-Barthélemy',
		'Saint-Martin (franz. Teil)' => 'Saint-Martin (franz. Teil)',
		'Sambia' => 'Sambia',
		'Samoa' => 'Samoa',
		'San Marino' => 'San Marino',
		'São Tomé und Príncipe' => 'São Tomé und Príncipe',
		'Saudi-Arabien' => 'Saudi-Arabien',
		'Schweden' => 'Schweden',
		'Senegal' => 'Senegal',
		'Serbien' => 'Serbien',
		'Seychellen' => 'Seychellen',
		'Sierra Leone' => 'Sierra Leone',
		'Simbabwe' => 'Simbabwe',
		'Singapur' => 'Singapur',
		'Sint Maarten (niederl. Teil)' => 'Sint Maarten (niederl. Teil)',
		'Slowakei' => 'Slowakei',
		'Slowenien' => 'Slowenien',
		'Somalia' => 'Somalia',
		'Spanien' => 'Spanien',
		'Sri Lanka' => 'Sri Lanka',
		'St. Helena' => 'St. Helena',
		'St. Kitts und Nevis' => 'St. Kitts und Nevis',
		'St. Lucia' => 'St. Lucia',
		'Saint-Pierre und Miquelon' => 'Saint-Pierre und Miquelon',
		'St. Vincent und die Grenadinen' => 'St. Vincent und die Grenadinen',
		'Südafrika' => 'Südafrika',
		'Sudan' => 'Sudan',
		'Südgeorgien und die Südlichen Sandwichinseln' => 'Südgeorgien und die Südlichen Sandwichinseln',
		'Südsudan' => 'Südsudan',
		'Suriname' => 'Suriname',
		'Svalbard und Jan Mayen' => 'Svalbard und Jan Mayen',
		'Swasiland' => 'Swasiland',
		'Syrien, Arabische Republik' => 'Syrien, Arabische Republik',
		'Tadschikistan' => 'Tadschikistan',
		'Republik China (Taiwan)' => 'Republik China (Taiwan)',
		'Tansania, Vereinigte Republik' => 'Tansania, Vereinigte Republik',
		'Thailand' => 'Thailand',
		'Togo' => 'Togo',
		'Tokelau' => 'Tokelau',
		'Tonga' => 'Tonga',
		'Trinidad und Tobago' => 'Trinidad und Tobago',
		'Tschad' => 'Tschad',
		'Tschechien' => 'Tschechien',
		'Tunesien' => 'Tunesien',
		'Türkei' => 'Türkei',
		'Turkmenistan' => 'Turkmenistan',
		'Turks- und Caicosinseln' => 'Turks- und Caicosinseln',
		'Tuvalu' => 'Tuvalu',
		'Uganda' => 'Uganda',
		'Ukraine' => 'Ukraine',
		'Ungarn' => 'Ungarn',
		'United States Minor Outlying Islands' => 'United States Minor Outlying Islands',
		'Uruguay' => 'Uruguay',
		'Usbekistan' => 'Usbekistan',
		'Vanuatu' => 'Vanuatu',
		'Vatikanstadt' => 'Vatikanstadt',
		'Venezuela' => 'Venezuela',
		'Vereinigte Arabische Emirate' => 'Vereinigte Arabische Emirate',
		'Vereinigte Staaten von Amerika' => 'Vereinigte Staaten von Amerika',
		'Vereinigtes Königreich Großbritannien und Nordirland' => 'Vereinigtes Königreich Großbritannien und Nordirland',
		'Vietnam' => 'Vietnam',
		'Wallis und Futuna' => 'Wallis und Futuna',
		'Weihnachtsinsel' => 'Weihnachtsinsel',
		'Westsahara' => 'Westsahara',
		'Zentralafrikanische Republik' => 'Zentralafrikanische Republik',
		'Zypern' => 'Zypern',
	);
}
