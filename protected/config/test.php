<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
			'connectionString' => 'mysql:host=www.jiaozuoye.com;dbname=book_share_test',
			'emulatePrepare' => true,
			'username' => 'book',
			'password' => 'booktest',
			'charset' => 'utf8',
                        ),
		),
	)
);
