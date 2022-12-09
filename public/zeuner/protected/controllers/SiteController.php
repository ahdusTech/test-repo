<?php

class SiteController extends Controller
{
	public $auction;
	public $price;
	public $date;
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$domain = TblDomain::model(
		)->find(
			'LOWER(name)=?',
			array(
				$_GET[
					'domain'
				]
			)
		);
		if (
			$domain === null
		) {
			$newly_encountered = new TblDomain;
			$newly_encountered->name = $_GET[
				'domain'
			];
			if (
				!$newly_encountered->save(
				)
			) {
				foreach (
					$newly_encountered->getErrors(
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
			$domain = TblDomain::model(
			)->find(
				'LOWER(name)=?',
				array(
					$_GET[
						'domain'
					]
				)
			);
		}
		if (
			$domain === null
		) {
			throw new CHttpException(
				404,
				Yii::t(
					'app',
					'Seite nicht gefunden.'
				)
			);
		}
		$title = $domain->auction ? Yii::t(
			'app',
			'{domain} steht zum Verkauf',
			array(
				'{domain}' => $domain->name,
			)
		) : Yii::t(
			'app',
			'Informationen zur Domain {domain}',
			array(
				'{domain}' => $domain->name,
			)
		);
		$this->layout = 'none';
		$this->render(
			'frameset',
			array(
				'title' => $title,
				'frame' => $this->createUrl(
					'tblDomain/status',
					array(
						'id' => $domain->id,
					)
				),
			)
		);
	}

	/**
	 * This is the 'redirect_ssl' action to redirect system domain
	 * visitors to the SSL pages
	 */
	public function actionRedirect_ssl()
	{
		$this->redirect(
			array(
				'tblDomain/index_auctions',
			)
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionAjaxDate(
	) {
		if (
			!Yii::app(
			)->request->isAjaxRequest
		) {
			throw new CHttpException(
				'403',
				'Forbidden access.'
			);
		}
		header(
			'Content-Type: application/json; charset="UTF-8"'
		);
		echo json_encode(
			str_replace(
				" ",
				"T",
				Yii::app(
				)->Date->now(
				)
			)
		);
		Yii::app(
		)->end(
		);
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		throw new CHttpException(
			'500',
			'Ressource deaktiviert'
		);
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$model->password = '';
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
