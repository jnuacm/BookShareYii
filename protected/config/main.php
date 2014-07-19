<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'BookShare',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
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
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                                array('site/phonelogin', 'pattern'=>'api/login', 'verb'=>'GET'),
                                array('site/phoneregister', 'pattern'=>'api/register', 'verb'=>'GET'),
                            
                                // REST patterns
                                array('<model>/phoneList', 'pattern'=>'api/<model:\w+>', 'verb'=>'GET'),
                                array('<model>/phoneView', 'pattern'=>'api/<model:\w+>/<id:\w+>', 'verb'=>'GET'),
                                array('<model>/phoneUpdate', 'pattern'=>'api/<model:\w+>/<id:\w+>', 'verb'=>'PUT'),
                                array('<model>/phoneDelete', 'pattern'=>'api/<model:\w+>/<id:\w+>', 'verb'=>'DELETE'),
                                array('<model>/phoneCreate', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),
			),
		),
		
                /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
                */
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=www.jiaozuoye.com;dbname=book_share',
			'emulatePrepare' => true,
			'username' => 'book',
			'password' => 'booktest',
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
		'adminEmail'=>'webmaster@example.com',
	),
);