<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CMS Platform',
    'theme'=>'classic',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.widgets.*',
        'application.vendors.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'archivesite',
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

        'urlManager' => array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'rules'=>array(
                    'gii'=>'gii',
                    'gii/<controller:\w+>'=>'gii/<controller>',
                    'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
                    '<module:\w+>/<action:\w+>'=>'<module>/default/<action>',
                    '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                    '<action:\w+>'=>'site/<action>',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                )
        ),

		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sup_admin',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
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
					'levels'=>'error, warning,info',
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
	'params'=>array(
		// this is used in contact page
		'site_domain'=>'cms.platform.dev/',
	),
);