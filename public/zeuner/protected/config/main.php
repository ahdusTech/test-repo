<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

Yii::setPathOfAlias(
	'protected',
	dirname(
		__FILE__
	) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'protected'
);

Yii::setPathOfAlias(
	'usr',
	dirname(
		__FILE__
	) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'usr'
);

Yii::$enableIncludePath = FALSE;

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Domainvermarktung',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
	),

	/*'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'WhyftAmwib',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.23','127.0.0.1','::1'),
		),
	),*/

	'sourceLanguage' => 'de-DE',
	'language' => 'de-DE',

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin' => TRUE,

			'loginUrl' => array(
				'site/login',
			),
		),

		// URL settings are configured in urls.php
		'urlManager'=>require(dirname(__FILE__).'/urls.php'),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'authManager' => array(
			'class' => 'CDbAuthManager',
			'connectionID' => 'db',
			'defaultRoles' => array(
				'initiator',
				'buyer',
			),
			'itemTable' => 'tbl_auth_item',
			'itemChildTable' => 'tbl_auth_item_child',
			'assignmentTable' => 'tbl_auth_assignment',
		),

		'request' => array(
			'enableCsrfValidation' => TRUE,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'smarty'=>array(
			'class' => 'application.extensions.CSmarty',
		),

		// sms settings are configured in introspectable/sms_gateway.php
		'smsGateway'=>require(dirname(__FILE__).'/introspectable/sms_gateway.php'),
		'Date'=>require(dirname(__FILE__).'/date.php'),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

		'mailer' => array(
			'class' => 'usr.extensions.mailer.EMailer',
			'pathViews' => 'usr.views.email',
			'pathLayouts' => 'usr.views.email.layouts',
			'Host' => '127.0.0.1',
		),

		'format' => array(
			'class' => 'application.components.Formatter',
			'dateFormat' => 'd.m.Y',
		),

	),

	'behaviors' => array(
		'onbeginRequest' => array(
			'class' => 'application.components.LanguageSelectingBehavior',
			'supported_languages' => array(
				'en-US',
				'de-DE',
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/introspectable/params.php'),
);
