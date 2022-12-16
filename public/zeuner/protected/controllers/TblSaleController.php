<?php

class TblSaleController extends Controller
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
		$params = array(
		);
		$id = Yii::app(
		)->request->getParam(
			"id"
		);
		if (
			isset(
				$id
			)
		) {
			$params[
				"sale"
			] = $this->loadModel(
				$id
			);
		}
		return array(
			array('allow', // allow buyer to view the record
				'actions'=>array('status'),
				'roles'=>array('buyer' => $params),
			),
			array('allow', // allow buyers to list their acquisitions
				'actions'=>array('index_own'),
				'users'=>array('@'),
			),
			array('allow', // allow admin role to perform CRUD actions
				'actions'=>array(
					'admin',
					'delete',
					'index',
					'view',
					'update',
				),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Shows the status of a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionStatus($id)
	{
		$sale = $this->loadModel(
			$id
		);
		$domain = TblDomain::model(
		)->findByPk(
			$sale->domain
		);
		if($domain===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$this->render('status',array(
			'sale' => $sale,
			'domain' => $domain,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel(
			$id
		);
		$buyer = $this->loadUserModel(
			$model->buyer
		);
		$domain = $this->loadDomainModel(
			$model->domain
		);
		$this->render('view',array(
			'model' => $model,
			'buyer' => $buyer,
			'domain' => $domain,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TblSale;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['TblSale']))
		{
			$model->attributes=$_POST['TblSale'];
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
		$this->performAjaxValidation($model);

		if(isset($_POST['TblSale']))
		{
			$model->attributes=$_POST['TblSale'];
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
		$dataProvider=new CActiveDataProvider('TblSale');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all models where the logged user is the buyer.
	 */
	public function actionIndex_own()
	{
		$sale = new TblSale(
			'search'
		);
		$sale->unsetAttributes(
		);
		$sale->buyer = Yii::app(
		)->user->id;
		$dataProvider = $sale->search(
		);
		$this->render(
			'index_own',
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TblSale('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TblSale']))
			$model->attributes=$_GET['TblSale'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblSale the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TblSale::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the user model based on the primary key
	 * If the user model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadUserModel($id)
	{
		$model=User::model()->findByPk($id);
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
	 * Performs the AJAX validation.
	 * @param TblSale $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbl-sale-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
