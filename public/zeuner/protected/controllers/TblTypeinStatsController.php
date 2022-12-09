<?php

class TblTypeinStatsController extends Controller
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
			array('allow',  // allow admin user to perform 'index' and 'index_domain' actions
				'actions'=>array(
					'index',
					'index_date',
					'index_domain',
				),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('TblTypeinStats');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all models related to a specific domain
	 * @param integer $id the ID of the domain model to filter for
	 */
	public function actionIndex_domain($id)
	{
		$stats = new TblTypeinStats(
			'search'
		);
		$stats->unsetAttributes();  // clear any default values
		$stats->domain = $id;

		$dataProvider = $stats->search(
		);
		$sort = new CSort(
		);
		$sort->defaultOrder = array(
			'access_date' => CSort::SORT_DESC,
		);
		$dataProvider->setSort(
			$sort
		);

		$this->render('index',array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Lists all models related to a specific access date
	 * @param string $date the access date to filter for
	 */
	public function actionIndex_date($date)
	{
		$stats = new TblTypeinStats(
			'search'
		);
		$stats->unsetAttributes();  // clear any default values
		$stats->access_date = $date;

		$dataProvider = $stats->search(
		);
		$sort = new CSort(
		);
		$sort->defaultOrder = array(
			'domain' => CSort::SORT_ASC,
		);
		$dataProvider->setSort(
			$sort
		);

		$this->render('index',array(
			'dataProvider' => $dataProvider,
		));
	}
}
