<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cộng đồng Việt Nhật',
	
// preloading 'log' component
	'preload'=>array('log'),

// autoloading model and component classes
	'import'=>array(
            'application.models.*',
			'application.models.form.*',
            'application.components.*',
            'application.modules.content.*',
            'application.modules.content.models.*',
			'application.extensions.validators.*',
           
    ),

	'modules'=>array(
// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'vietnam123',
// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
),

),

// application components
	'components'=>array(
		'user'=>array(
// enable cookie-based authentication
			'allowAutoLogin'=>true,
),
// uncomment the following to enable URLs in path-format
/*
 'urlManager'=>array(
 'urlFormat'=>'path',
 'rules'=>array(
 '<controller:\w+>/<id:\d+>'=>'<controller>/view',
 '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
 '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
 ),
 ),

 'db'=>array(
 'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
 ),*/
// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=vjc',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
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
					'levels'=>'error, warning',
),
// uncomment the following to show log messages on web pages

array(
					'class'=>'CWebLogRoute',
),

),
),
),

// application-level parameters that can be accessed
// using Yii::app()->params['paramName']
	'params'=>array(
// this is used in contact page
		'imagePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../images',
		'mainsiteUrl'=>"www.local.public.vjc-online.com",
		'adminEmail'=>'congdongvietnhat@gmail.com',
                'configFB'=> array(
                    'appId' => '740040962692690',
                    'secret' => '8be197c149527a1bccdc5548bcb739b4',
                    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
),
                'groupID'=>'229244010425617',
),
);