<?php

// This is the URL configuration.

$staging_subdomain = '';

return array(
	'showScriptName' => FALSE,
	'urlFormat'=>'path',
	'rules'=>array(
		'https://www.adomino.net' . $staging_subdomain . '/'=>'tblDomain/index_auctions',
		'https://www.adomino.net' . $staging_subdomain . '/<controller:\w+>/<id:\d+>'=>'<controller>/view',
		'https://www.adomino.net' . $staging_subdomain . '/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'http://adomino.net' . $staging_subdomain . '/'=>'site/redirect_ssl',
		'http://www.adomino.net' . $staging_subdomain . '/'=>'site/redirect_ssl',
		'http://<domain:(\w|\.)+>' . $staging_subdomain . '/'=>'site/index',
		'http://<domain:(\w|\.)+>' . $staging_subdomain . '/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		'https://www.adomino.net' . $staging_subdomain . '/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
	),
);
