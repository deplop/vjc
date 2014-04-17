<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	'import'=>array(
            'application.models.*',
			'application.models.form.*',
            'application.components.*',
            'application.modules.content.*',
            'application.modules.content.models.*',
			'application.extensions.validators.*',
           
    ),

	// application components
	'components'=>array(
		/*
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
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	'params'=>array(
		'groupID'=>'229244010425617',
		'configFB'=>array(
                    'appId' => '740040962692690',
                    'secret' => '8be197c149527a1bccdc5548bcb739b4',
                    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
		),
	),
);