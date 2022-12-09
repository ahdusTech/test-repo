<?php

class TblContactDataController extends Controller
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
			array('allow', // allow admin user to perform CRUD and choose_template actions
				'actions'=>array(
					'admin',
					'choose_template',
					'send_mail',
					'finish_mail',
					'index',
					'view',
				),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$contact_data = $this->loadModel(
			$id
		);
		$domain = $this->loadDomainModel(
			$contact_data->domain
		);
		$this->render('view',array(
			'model' => $contact_data,
			'domain' => $domain,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TblContactData;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblContactData']))
		{
			$model->attributes=$_POST['TblContactData'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

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
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblContactData']))
		{
			$model->attributes=$_POST['TblContactData'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$dataProvider=new CActiveDataProvider('TblContactData');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Send mail
	 * @param integer $id the ID of the model to get contact data from
	 */
	public function actionSend_mail($id)
	{
		$contact_data = $this->loadModel(
			$id
		);
		$domain = $this->loadDomainModel(
			$contact_data->domain
		);
		$model=new OutboundForm;

		if(isset($_POST['ajax']) && $_POST['ajax']==='outbound-form-finish_mail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['OutboundForm']))
		{
			$model->attributes=$_POST['OutboundForm'];
			if($model->validate())
			{
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
					$contact_data->email
				);
				Yii::app(
				)->mailer->Subject = $model->subject;
				Yii::app(
				)->mailer->Body = $model->body;
				Yii::app(
				)->mailer->Send(
				);
				Yii::app(
				)->user->setFlash(
					'domain',
					'Eine E-Mail-Nachricht an
' . $contact_data->email . ' wurde soeben versandt.'
				);
				$this->redirect(
					array(
						'tblDomain/index',
					)
				);
				return;
			}
		}
		$this->render(
			'finish_mail',
			array(
				'model'=>$model,
				'domain'=>$domain,
				'contact_data'=>$contact_data,
			)
		);
	}

	/**
	 * Expand a mail template to initiate correspondence, allow editing
	 *  of the expanded content
	 * @param integer $id the ID of the model to get contact data from
	 * @param integer $template the ID of the tblMailTemplate model to get
	 *  contact data from
	 */
	public function actionFinish_mail($id, $template)
	{
		$model=new OutboundForm;
		$contact_data = $this->loadModel(
			$id
		);
		$domain = $this->loadDomainModel(
			$contact_data->domain
		);
		Yii::app(
		)->smarty->registerResource(
			'template',
			new Smarty_Resource_TblMailTemplate(
			)
		);
		Yii::app(
		)->smarty->registerResource(
			'template_subject',
			new Smarty_Resource_TblMailTemplate_subject(
			)
		);
		Yii::app(
		)->smarty->assign(
			'contact',
			$contact_data
		);
		Yii::app(
		)->smarty->assign(
			'domain',
			$domain
		);

		$model->subject = Yii::app(
		)->smarty->fetch(
			'template_subject:' . $template
		);

		$model->body = Yii::app(
		)->smarty->fetch(
			'template:' . $template
		);

		$this->render(
			'finish_mail',
			array(
				'model'=>$model,
				'domain'=>$domain,
				'contact_data'=>$contact_data,
			)
		);
	}

	/**
	 * Choose a mail template to initiate correspondence
	 * @param integer $id the ID of the model to get contact data from
	 */
	public function actionChoose_template($id)
	{
		$contact_data = $this->loadModel(
			$id
		);
		$domain = $this->loadDomainModel(
			$contact_data->domain
		);

		$dataProvider = new CActiveDataProvider(
			'TblMailTemplate'
		);
		$this->render('choose_template',array(
			'dataProvider'=>$dataProvider,
			'domain' => $domain,
			'contact_data' => $contact_data,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TblContactData('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TblContactData']))
			$model->attributes=$_GET['TblContactData'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblContactData the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TblContactData::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the tblDomain model based on the primary key
	 * If the tblDomain model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblDomain the loaded model
	 * @throws CHttpException
	 */
	public function loadDomainModel($id)
	{
		$model=TblDomain::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the tblMailTemplate model based on the primary key
	 * If the tblMailTemplate model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblMailTemplate the loaded model
	 * @throws CHttpException
	 */
	public function loadMailTemplateModel($id)
	{
		$model=TblMailTemplate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TblContactData $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbl-contact-data-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * @inheritdoc
	 */
	public function getActionParams()
	{
		return $_REQUEST;
	}
}
