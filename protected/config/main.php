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
                        'api/login'=>'site/login',
                        'api/register'=>'site/register',
                        // REST patterns
						array('avatar/create', 'pattern'=>'api/avatar/<user:\w+>', 'verb'=>'POST'),
						array('avatar/view', 'pattern'=>'api/avatar/<user:\w+>', 'verb'=>'GET'),
						array('avatar/update', 'pattern'=>'api/avatar/<user:\w+>', 'verb'=>'PUT'),
						array('avatar/delete', 'pattern'=>'api/avatar/<user:\w+>', 'verb'=>'DELETE'),
						
						array('comment/listOnIsbn', 'pattern'=>'api/comment/isbn/<isbn:\w+>', 'verb'=>'GET'),
						array('comment/create', 'pattern'=>'api/comment/isbn/<isbn:\w+>', 'verb'=>'POST'),
						
                        array('book/<suffix>list', 'pattern'=>'api/book/<user:\w+>/<suffix:((all)|(own)|(borrowed))>', 'verb'=>'GET'),
                        array('book/history', 'pattern'=>'api/book/<id:\w+>/history', 'verb'=>'GET'),
                        array('book/search', 'pattern'=>'api/book/search', 'verb'=>'GET'),
                        array('request/<suffix>userList', 'pattern'=>'api/request/<suffix:(()|(from)|(to))>/<user:\w+>', 'verb'=>'GET'),
                        
                        array('friendship/list', 'pattern'=>'api/friend', 'verb'=>'GET'),
                        array('friendship/create', 'pattern'=>'api/friend', 'verb'=>'POST'),
                        array('friendship/delete', 'pattern'=>'api/friend/<friend:\w+>', 'verb'=>'DELETE'),
                        
                        array('<model>/list', 'pattern'=>'api/<model:\w+>', 'verb'=>'GET'),
                        array('<model>/view', 'pattern'=>'api/<model:\w+>/<id:\w+>', 'verb'=>'GET'),
                        array('<model>/update', 'pattern'=>'api/<model:\w+>/<id:\w+>', 'verb'=>'PUT'),
                        array('<model>/delete', 'pattern'=>'api/<model:\w+>/<id:\w+>', 'verb'=>'DELETE'),
                        array('<model>/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),                        
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