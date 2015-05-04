<?php

function error_output ( $str )
{
	echo "\033[1;40;31m" . $str ."\033[0m" . "\n";
}

function right_output ( $str )
{
	echo "\033[1;40;32m" . $str ."\033[0m" . "\n";
}

function pushMessage_android ($user_id, $content, $push_type = 1)
{
	require_once ( dirname(__FILE__)."/../Channel.class.php" ) ;
	$apiKey = "OErne3qA5cR5q14A0rZiSIaF";
	$secretKey = "F55YD1YHXNu35lDKQtPUlOzZkp0CfbVp";
	$channel = new Channel ( $apiKey, $secretKey ) ;
	$optional[Channel::USER_ID] = $user_id;
	$optional[Channel::DEVICE_TYPE] = 3;
	$optional[Channel::MESSAGE_TYPE] = 0;
	$message = json_encode($content);
	$message_key = "msg_key";
	$ret = $channel->pushMessage ( $push_type, $message, $message_key, $optional ) ;
}