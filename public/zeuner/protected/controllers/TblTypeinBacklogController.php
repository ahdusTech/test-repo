<?php

class TblTypeinBacklogController extends Controller
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
			array('allow', // allow admin user to perform the 'index' action
				'actions'=>array(
					'index',
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TblTypeinBacklog;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblTypeinBacklog']))
		{
			$model->attributes=$_POST['TblTypeinBacklog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->domain));
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

		if(isset($_POST['TblTypeinBacklog']))
		{
			$model->attributes=$_POST['TblTypeinBacklog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->domain));
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
		$dataProvider = new CActiveDataProvider(
			'TblTypeinBacklog'
		);
		foreach (
			$dataProvider->getData(
			) as $id => $sample
		) {
			$aggregated_on = $sample->aggregated_on;
			break;
		}
		$parsed = strptime(
			$aggregated_on,
			"%Y-%m-%d %H:%M:%S"
		);
		$timestamp = mktime(
			$parsed[
				"tm_hour"
			],
			$parsed[
				"tm_min"
			],
			$parsed[
				"tm_sec"
			],
			1 + $parsed[
				"tm_mon"
			],
			$parsed[
				"tm_mday"
			],
			1900 + $parsed[
				"tm_year"
			]
		);
		$column_dates = array(
		);
		for (
			$backlog = 0;
			10 > $backlog;
			$backlog++
		) {
			array_push(
				$column_dates,
				$timestamp - (
					$backlog * 86400
				)
			);
		}
		$dataProvider = new CActiveDataProvider(
			'TblTypeinBacklog'
		);
		$this->render('index',array(
			'dataProvider' => $dataProvider,
			'column_dates' => $column_dates,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TblTypeinBacklog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TblTypeinBacklog']))
			$model->attributes=$_GET['TblTypeinBacklog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblTypeinBacklog the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TblTypeinBacklog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TblTypeinBacklog $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbl-typein-backlog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
