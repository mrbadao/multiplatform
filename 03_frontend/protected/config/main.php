<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
	'theme' => 'eshopper',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.widgets.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(

		'viewRenderer' => array(
			'class' => 'ext.PHPTALViewRenderer',
			'fileExtension' => '.html',
		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => false,
			'rules'=>array(
                array(
                    'class' => 'application.components.urlrule.SiteUrlRule',
                ),
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),


		// database settings are configured in database.php
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=sup_admin',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'initSQLs' => array("set time_zone='+07:00';"),
        ),

        'db_archive' => array(
            'connectionString' => 'mysql:host=localhost;dbname=sup_archive',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'initSQLs' => array("set time_zone='+07:00';"),
            'class' => 'CDbConnection',
        ),

        'db_staff' => array(
            'connectionString' => 'mysql:host=localhost;dbname=sup_staff',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'initSQLs' => array("set time_zone='+07:00';"),
            'class' => 'CDbConnection',
        ),

        'db_backup' => array(
            'connectionString' => 'mysql:host=localhost;',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'initSQLs' => array("set time_zone='+07:00';"),
            'class' => 'CDbConnection',
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

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

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'FRONT_DOMAIN' => 'platform.com',
	),
);
