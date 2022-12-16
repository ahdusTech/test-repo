<?php
/* @var $this TblTypeinBacklogController */
/* @var $dataProvider CActiveDataProvider */
/* @var $column_dates array */

$this->breadcrumbs=array(
        'Typeins',
);

$this->menu=array(
);

$this->pageTitle = Yii::app()->name.' - '.'Typeins';
?>

<h1>Typeins</h1>

<?php
$days = 0;
$first = array_shift(
	$column_dates
);
$year = strftime(
	"%Y",
	$first
);
$month = strftime(
	"%m",
	$first
);
$day = strftime(
	"%d",
	$first
);
$columns = array(
	array(
		'class' => 'CDataColumn',
		'header' => 'Domain',
		'value' => 'TblDomain::model()->findByPk($data->domain)->name',
	),
	array(
		'class' => 'CDataColumn',
		'header' => "$day.",
		'name' => "backlog$days",
		'htmlOptions' => array(
			'style' => 'text-align: right',
		),
	)
);
foreach(
	$column_dates as $current
) {
	$days++;
	$last_year = $year;
	$last_month = $month;
	$last_day = $day;
	$year = strftime(
		"%Y",
		$current
	);
	$month = strftime(
		"%m",
		$current
	);
	$day = strftime(
		"%d",
		$current
	);
	$title = "$day.";
	if (
		$last_month != $month
	) {
		$title .= "$month.";
	}
	if (
		$last_year != $year
	) {
		$title .= $year;
	}
	array_push(
		$columns,
		array(
			'class' => 'CDataColumn',
			'header' => $title,
			'name' => "backlog$days",
			'htmlOptions' => array(
				'style' => 'text-align: right',
			),
		)
	);
}
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tbl-typein-backlog-grid',
	'dataProvider' => $dataProvider,
	'columns' => $columns,
));
?>
