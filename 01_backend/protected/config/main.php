<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'CMS Platform',
    'theme' => 'classic',
    'timeZone' => 'Asia/Saigon',
    // preloading 'log' component
    'preload' => array('log'),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*',
        'application.widgets.*',
        'application.vendors.*',
    ),

    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'archivesite',
        'modulemanage',
        'systemsetting',
        'systemusers',
    ),

    // application components
    'components' => array(
        'viewRenderer' => array(
            'class' => 'ext.PHPTALViewRenderer',
            'fileExtension' => '.html',
        ),

        'CodeMirror' => array(
            'class' => 'ext.CodeMirrorExtendsion',
        ),

        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),

        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',

                array(
                    'class' => 'application.components.urlrule.SystemUsersUrlRule',
                ),
                array(
                    'class' => 'application.components.urlrule.SiteUrlRule',
                ),
                array(
                    'class' => 'application.components.urlrule.ArchiveSiteUrlRule',
                ),
                array(
                    'class' => 'application.components.urlrule.ModuleManageUrlRule',
                ),
				array(
                    'class' => 'application.components.urlrule.SystemSettingUrlRule',
                ),
            )
        ),

        // uncomment the following to use a MySQL database

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

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning,info',
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
    'params' => array(
        'DbBackupPath' => "application.runtime.backups",
        'CMS_DOMAIN' => 'cms.platform.com',
        'CP_DOMAIN' => 'cpanel.platform.com',
        'FRONT_DOMAIN' => 'platform.com',
        'pageCountItems' => '10',
        'super_id' => '1',

        'module' => array(
            'zipPath' => "application.runtime.modules.zip",
            'tempPath' => "application.runtime.modules.temp",
        ),

        'DataBaseList' => array(
            'db' => 'Admin',
            'db_archive' => 'Archive',
            'db_staff' => 'Staff',
        ),
    ),
);