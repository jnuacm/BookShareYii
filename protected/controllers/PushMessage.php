<?php

function error_output ( $str )
{
	echo "\033[1;40;31m" . $str ."\033[0m" . "\n";
}

function right_output ( $str )
{
	echo "\033[1;40;32m" . $str ."\033[0m" . "\n";
}

//推送android设备消息
function pushMessage_android ($user_id, $content)
{
	require_once ( "/../Channel.class.php" ) ;
	$apiKey = "OErne3qA5cR5q14A0rZiSIaF";
	$secretKey = "F55YD1YHXNu35lDKQtPUlOzZkp0CfbVp";
	$channel = new Channel ( $apiKey, $secretKey ) ;
	//推送消息到某个user，设置push_type = 1;
	//推送消息到一个tag中的全部user，设置push_type = 2;
	//推送消息到该app中的全部user，设置push_type = 3;
	$push_type = 1; //推送单播消息
	$optional[Channel::USER_ID] = $user_id; //如果推送单播消息，需要指定user
	//optional[Channel::TAG_NAME] = "xxxx";  //如果推送tag消息，需要指定tag_name
	
	//指定发到android设备
	$optional[Channel::DEVICE_TYPE] = 3;
	//指定消息类型为透传
	$optional[Channel::MESSAGE_TYPE] = 0;
	//通知类型的内容必须按指定内容发送，示例如下：

	$message = json_encode($content);
	
	$message_key = "msg_key";
	$ret = $channel->pushMessage ( $push_type, $message, $message_key, $optional ) ;
}