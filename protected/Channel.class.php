<?php
if ( ! defined ( 'API_ROOT_PATH' ) ) 
{
	define ( 'API_ROOT_PATH', dirname( __FILE__));
}
require_once ( API_ROOT_PATH . '/lib/RequestCore.class.php' );
require_once ( API_ROOT_PATH . '/lib/ChannelException.class.php' );
require_once ( API_ROOT_PATH . '/lib/BaeBase.class.php' );
class Channel extends BaeBase
{
	const TIMESTAMP = 'timestamp';
	const EXPIRES = 'expires';
	const VERSION = 'v';
	const CHANNEL_ID = 'channel_id';
	const USER_TYPE = 'user_type';
	const DEVICE_TYPE = 'device_type';
	const START = 'start';
	const LIMIT = 'limit';
	const MSG_IDS = 'msg_ids';
	const MSG_KEYS = 'msg_keys';
	const IOS_MESSAGES = 'ios_messages';
	const WP_MESSAGES = 'wp_messages';
	const MESSAGE_TYPE = 'message_type';
	const MESSAGE_EXPIRES = 'message_expires';
	const DEPLOY_STATUS = 'deploy_status';
    const TAG_NAME = 'tag';
    const TAG_INFO = 'info';
    const TAG_ID = 'tid';
    const BANNED_TIME = 'banned_time';
    const CALLBACK_DOMAIN = 'domain';
    const CALLBACK_URI = 'uri';

	const APPID = 'appid';
	const ACCESS_TOKEN = 'access_token';
	const API_KEY = 'apikey';
	const SECRET_KEY = 'secret_key';
	const SIGN = 'sign';
	const METHOD = 'method';
	const HOST = 'host';
	const USER_ID = 'user_id';
	const MESSAGES = 'messages';
	const PRODUCT = 'channel';
	
	const HOST_DEFAULT = 'http://channel.api.duapp.com';
	const HOST_IOS_DEV = 'https://channel.iospush.api.duapp.com';
	const NAME = "name";
	const DESCRIPTION = "description";
	const CERT = "cert"; 
	const RELEASE_CERT = "release_cert";
	const DEV_CERT = "dev_cert";
	const PUSH_TYPE = 'push_type';

	protected $_apiKey = NULL;
	protected $_secretKey = NULL;
	protected $_requestId = 0;
	protected $_curlOpts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 5
        );
	protected $_host = self::HOST_DEFAULT;

	const PUSH_TO_USER = 1;
	const PUSH_TO_TAG = 2;
	const PUSH_TO_ALL = 3;
	const PUSH_TO_DEVICE = 4;

	const CHANNEL_SDK_SYS = 1;
	const CHANNEL_SDK_INIT_FAIL = 2;
	const CHANNEL_SDK_PARAM = 3;
	const CHANNEL_SDK_HTTP_STATUS_ERROR_AND_RESULT_ERROR = 4;
	const CHANNEL_SDK_HTTP_STATUS_OK_BUT_RESULT_ERROR = 5;

	protected $_arrayErrorMap = array
		( 
		 '0' => 'php sdk error',
		 self::CHANNEL_SDK_SYS => 'php sdk error',
		 self::CHANNEL_SDK_INIT_FAIL => 'php sdk init error',
		 self::CHANNEL_SDK_PARAM => 'lack param',
		 self::CHANNEL_SDK_HTTP_STATUS_ERROR_AND_RESULT_ERROR => 'http status is error, and the body returned is not a json string',
		 self::CHANNEL_SDK_HTTP_STATUS_OK_BUT_RESULT_ERROR => 'http status is ok, but the body returned is not a json string',
		);

     protected $_method_channel_in_body = array
        (
        'push_msg',
        'set_tag',
        'fetch_tag',
        'delete_tag',
        'query_user_tags'
        );
	

	public function setApiKey ( $apiKey )
	{
		$this->_resetErrorStatus (  );
		try
		{
			if ( $this->_checkString ( $apiKey, 1, 64 ) )
			{
				$this->_apiKey = $apiKey;
			}
			else 
			{
				throw new ChannelException ( "invaid apiKey ( ${apiKey} ), which must be a 1 - 64 length string", self::CHANNEL_SDK_INIT_FAIL );
			}
		}
		catch ( Exception $ex )
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
		return true;
	}

	public function setSecretKey ( $secretKey )
	{
		$this->_resetErrorStatus (  );
		try
		{
			if ( $this->_checkString ( $secretKey, 1, 64 ) )
			{
				$this->_secretKey = $secretKey;
			}
			else 
			{
				throw new ChannelException ( "invaid secretKey ( ${secretKey} ), which must be a 1 - 64 length string", self::CHANNEL_SDK_INIT_FAIL );
			}
		}
		catch ( Exception $ex )
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
		return true;
	}
	
	
	public function setCurlOpts($arr_curlOpts)
	{
		$this->_resetErrorStatus();
		try {
			if (is_array($arr_curlOpts)) {
				$this->_curlOpts = $this->_curlOpts + $arr_curlOpts;
			}
			else  {
				throw new ChannelException( 'invalid param - arr_curlOpts is not an array ['
                        . print_r($arr_curlOpts, true) . ']',
                        self::CHANNEL_SDK_INIT_FAIL);
			}
		} catch (Exception $ex) {
			$this->_channelExceptionHandler( $ex );
			return false; 
		}
		return true;
	}

	public function setHost ( $host )
	{
		$this->_resetErrorStatus (  );
		try
		{
			if ( $this->_checkString ( $host, 1, 1024 ) )
			{
				$this->_host = $host;
			}
			else 
			{
				throw new ChannelException ( "invaid host ( ${host} ), which must be a 1 - 1024 length string", self::CHANNEL_SDK_INIT_FAIL );
			}
		}
		catch ( Exception $ex )
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
		return true;
	}

	public function getRequestId (  )
	{
		return $this->_requestId;
	}
	
	public function queryBindList ( $userId, $optional = NULL ) 
	{
		$this->_resetErrorStatus (  );
		try 
		{
			$tmpArgs = func_get_args (  );
			$arrArgs = $this->_mergeArgs ( array ( self::USER_ID ), $tmpArgs );
			$arrArgs [ self::METHOD ] = 'query_bindlist';
			return $this->_commonProcess ( $arrArgs );
		} 
		catch ( Exception $ex ) 
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
	}
	
	public function verifyBind ( $userId, $optional = NULL ) 
	{
		$this->_resetErrorStatus (  );
		try 
		{
			$tmpArgs = func_get_args (  );
			$arrArgs = $this->_mergeArgs ( array ( self::USER_ID ), $tmpArgs );
			$arrArgs [ self::METHOD ] = 'verify_bind';
			return $this->_commonProcess ( $arrArgs );
		} 
		catch ( Exception $ex ) 
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
	}
	
	public function fetchMessage ( $userId, $optional = NULL ) 
	{
		$this->_resetErrorStatus (  );
		try 
		{
			$tmpArgs = func_get_args (  );
			$arrArgs = $this->_mergeArgs ( array ( self::USER_ID ), $tmpArgs );
			$arrArgs [ self::METHOD ] = 'fetch_msg';
			return $this->_commonProcess ( $arrArgs );
		} 
		catch ( Exception $ex ) 
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
	}
	
	public function fetchMessageCount ( $userId, $optional = NULL ) 
	{
		$this->_resetErrorStatus (  );
		try 
		{
			$tmpArgs = func_get_args (  );
			$arrArgs = $this->_mergeArgs ( array ( self::USER_ID ), $tmpArgs );
			$arrArgs [ self::METHOD ] = 'fetch_msgcount';
			return $this->_commonProcess ( $arrArgs );
		} 
		catch ( Exception $ex ) 
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
	}
	
	public function deleteMessage ( $userId, $msgIds, $optional = NULL ) 
	{
		$this->_resetErrorStatus (  );
		try 
		{
			$tmpArgs = func_get_args (  );
			$arrArgs = $this->_mergeArgs ( array ( self::USER_ID, self::MSG_IDS ), $tmpArgs );
			$arrArgs [ self::METHOD ] = 'delete_msg';
			if(is_array($arrArgs [ self::MSG_IDS ])) {
				$arrArgs [ self::MSG_IDS ] = json_encode($arrArgs [ self::MSG_IDS ]);
			}
			return $this->_commonProcess ( $arrArgs );
		} 
		catch ( Exception $ex ) 
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
	}


	public function pushMessage($pushType, $messages, $msgKeys, $optional = NULL)
	{
		$this->_resetErrorStatus();
		try
		{
			$tmpArgs = func_get_args();
			$arrArgs = $this->_mergeArgs (array(self::PUSH_TYPE , self::MESSAGES, self::MSG_KEYS), $tmpArgs);
			$arrArgs[self::METHOD] = 'push_msg';

			switch($pushType)
			{
				case self::PUSH_TO_USER:
					if ( !array_key_exists(self::USER_ID, $arrArgs) || empty($arrArgs[self::USER_ID])){
						throw new ChannelException("userId should be specified in optional[] when pushType is PUSH_TO_USER", self::CHANNEL_SDK_PARAM);
					}
					break;
	
				case self::PUSH_TO_TAG:
					if (!array_key_exists(self::TAG_NAME, $arrArgs) || empty($arrArgs[self::TAG_NAME])){
						throw new ChannelException("tag should be specified in optional[] when pushType is PUSH_TO_TAG", self::CHANNEL_SDK_PARAM);
					}
					break;
		
				case self::PUSH_TO_ALL:
					break;

				default:
					throw new ChannelException("pushType($pushType) must be in range[1,3]", self::CHANNEL_SDK_PARAM);
			}

			$arrArgs[self::PUSH_TYPE] = $pushType;
			if(is_array($arrArgs [ self::MESSAGES ])) {
                $arrArgs [ self::MESSAGES ] = json_encode($arrArgs [ self::MESSAGES ]);
            }
            if(is_array($arrArgs [ self::MSG_KEYS ])) {
                $arrArgs [ self::MSG_KEYS ] = json_encode($arrArgs [ self::MSG_KEYS ]);
            }
            return $this->_commonProcess ( $arrArgs );
		}
		catch (Exception $ex)
		{
			$this->_channelExceptionHandler( $ex );
			return false;
		}
	}

 
	public function initAppIoscert($name, $description, $release_cert, $dev_cert, $optional = null)
	{		
		$this->_resetErrorStatus();
		try {
			$tmpArgs = func_get_args();
			$arrArgs = $this->_mergeArgs(array(self::NAME, self::DESCRIPTION, self::RELEASE_CERT, self::DEV_CERT), $tmpArgs);
			$arrArgs[self::METHOD] = "init_app_ioscert";
			return $this->_commonProcess($arrArgs);
		} catch(Exception $ex) {
			$this->_channelExceptionHandler($ex);
			return false;
		}
	}

	public function updateAppIoscert($optional = null)
	{		
		$this->_resetErrorStatus();
		try {
			$tmpArgs = func_get_args();
			$arrArgs = $this->_mergeArgs(array(), $tmpArgs);
			$arrArgs[self::METHOD] = "update_app_ioscert";
			return $this->_commonProcess($arrArgs);	
		} catch(Exception $ex) {
			$this->_channelExceptionHandler($ex);
			return false;
		}
	}

	public function queryAppIoscert($optional = null)
	{
		$this->_resetErrorStatus();
		try {
			$tmpArgs = func_get_args();
			$arrArgs = $this->_mergeArgs(array(), $tmpArgs);
			$arrArgs[self::METHOD] = "query_app_ioscert";	
			return $this->_commonProcess($arrArgs); 
		} catch(Exception $ex) {
			$this->_channelExceptionHandler($ex);
			return false;
		}
	}

	public function deleteAppIoscert($optional = null)
	{
		$this->_resetErrorStatus();
		try {
			$tmpArgs = func_get_args();
			$arrArgs = $this->_mergeArgs(array(), $tmpArgs);
			$arrArgs[self::METHOD] = "delete_app_ioscert";
			return $this->_commonProcess($arrArgs);
		} catch(Exception $ex) {
			$this->_channelExceptionHandler($ex);
			return false;
		}
	}
	
	public function queryDeviceType ( $channelId, $optional = NULL ) 
	{
		$this->_resetErrorStatus (  );
		try 
		{
			$tmpArgs = func_get_args (  );
			$arrArgs = $this->_mergeArgs ( array ( self::CHANNEL_ID ), $tmpArgs );
			$arrArgs [ self::METHOD ] = 'query_device_type';
			return $this->_commonProcess ( $arrArgs );
		} 
		catch ( Exception $ex ) 
		{
			$this->_channelExceptionHandler ( $ex );
			return false; 
		}
	}

	public function __construct ($apiKey = NULL, $secretKey = NULL, $arr_curlOpts = array())
	{
		if($this->_checkString($apiKey, 1, 64)){
			$this->_apiKey = $apiKey;
		}
		else{
			 throw new ChannelException("invalid param - apiKey[$apiKey],"
                    . "which must be a 1 - 64 length string",
                    self::CHANNEL_SDK_INIT_FAIL );
		}

		if($this->_checkString($secretKey, 1, 64)){
			$this->_secretKey = $secretKey;
		}
		else{
			throw new ChannelException("invalid param - secretKey[$secretKey],"
                    . "which must be a 1 - 64 length string",
                    self::CHANNEL_SDK_INIT_FAIL );
		}

		if (!is_array($arr_curlOpts)) {
			throw new ChannelException('invalid param - arr_curlopt is not an array ['
                    . print_r($arr_curlOpts, true) . ']',
                    self::CHANNEL_SDK_INIT_FAIL);
		}
        $this->_curlOpts = $this->_curlOpts + $arr_curlOpts;

        $this->_resetErrorStatus();
	}

	protected function _checkString($str, $min, $max)
	{
		if (is_string($str) && strlen($str) >= $min && strlen($str) <= $max) {
			return true;
		}
		return false;
	}

	protected function _getKey(&$opt,
            $opt_key,
            $member,
            $g_key,
            $env_key,
            $min,
            $max,
            $throw = true)
	{
        $dis = array(
            'access_token' => 'access_token',
            );
        global $$g_key;
        if (isset($opt[$opt_key])) {
            if (!$this->_checkString($opt[$opt_key], $min, $max)) {
                throw new ChannelException ( 'invalid ' . $dis[$opt_key] . ' in $optinal ('
                        . $opt[$opt_key] . '), which must be a ' . $min . '-' . $max
                        . ' length string', self::CHANNEL_SDK_PARAM );
            }
            return;
        }
        if ($this->_checkString($member, $min, $max)) {
            $opt[$opt_key] = $member;
            return;
        }
        if (isset($$g_key)) {
            if (!$this->_checkString($$g_key, $min, $max)) {
                throw new ChannelException('invalid ' . $g_key . ' in global area ('
                        . $$g_key . '), which must be a ' . $min . '-' . $max
                        . ' length string', self::CHANNEL_SDK_PARAM);
            }
            $opt[$opt_key] = $$g_key;
            return;
        }

        if (false !== getenv($env_key)) {
            if (!$this->_checkString(getenv($env_key), $min, $max)) {
                throw new ChannelException( 'invalid ' . $env_key . ' in environment variable ('
                        . getenv($env_key) . '), which must be a ' . $min . '-' . $max
                        . ' length string', self::CHANNEL_SDK_PARAM);
            }
            $opt[$opt_key] = getenv($env_key) ;
            return;
        }

        if ($opt_key === self::HOST) {
            $opt[$opt_key] = self::HOST_DEFAULT;
            return;
        }
        if ($throw) {
            throw new ChannelException('no param (' . $dis[$opt_key] . ') was found',
                    self::CHANNEL_SDK_PARAM);
        }
	}
	
	protected function _adjustOpt(&$opt)
	{
		if (!isset($opt) || empty($opt) || !is_array($opt)) {
			throw new ChannelException('no params are set',self::CHANNEL_SDK_PARAM);
		}
		if (!isset($opt[self::TIMESTAMP])) {
			$opt[self::TIMESTAMP] = time();
		}
		$this->_getKey($opt, self::HOST, $this->_host, 'g_host',
                'HTTP_BAE_ENV_ADDR_CHANNEL', 1, 1024, false);

        $this->_getKey($opt, self::API_KEY, $this->_apiKey,
                'g_apiKey', 'HTTP_BAE_ENV_AK', 1, 64, false);	
        
		if (isset($opt[self::SECRET_KEY])) {
			unset($opt[self::SECRET_KEY]);
		}
	}

	protected function _checkParams(&$params)
	{
		if ( !is_array($params)) {
			throw new ChannelException('no params',self::CHANNEL_SDK_PARAM);
		}
		foreach($params as $key => $value) {
			switch($key)
			{
				case self::USER_ID:
					if( !is_string($value)){
						throw new ChannelException("USER_ID($value) is not string", 
							self::CHANNEL_SDK_PARAM);
					}
					break;
				case self::CHANNEL_ID:
					if( !is_numeric($value)) {
						throw new ChannelException("CHANNEL_ID($value) is not numeric", 
							self::CHANNEL_SDK_PARAM);
					}
					break;
				case self::DEVICE_TYPE:
					if( !is_numeric($value) || $value < 0 || $value > 5 ) {
						throw new ChannelException( "invalid DEVICE_TYPE($value)",
 							self::CHANNEL_SDK_PARAM);
					}
					break;
				case self::TAG_NAME:
					if( !is_string($value) || strlen($value) > 128 ){
						throw new ChannelException( "TAG_NAME($value) must be a string and strlen <= 128",
							self::CHANNEL_SDK_PARAM);
					}
					break;
				case self::MESSAGE_TYPE:
					if( !is_numeric($value) || $value < 0 || $value > 1) {
						throw new ChannelException( "invalid MESSAGE_TYPE($value) must be 0 or 1",
 							self::CHANNEL_SDK_PARAM);
					}
					break;
				case self::NAME:
					if( !is_string($value) || strlen($value) > 128 ){
						throw new ChannelException( "IOS_CERT_NAME($value) must be a string and strlen <= 128",
							self::CHANNEL_SDK_PARAM);
					}
					break;
				case self::DESCRIPTION:
					if( !is_string($value) || strlen($value) > 256 ){
						throw new ChannelException( "IOS_CERT_DESCRIPTION($value) must be a string and strlen <= 256",
							self::CHANNEL_SDK_PARAM);
					}
					break;
			}
		}
	}
	protected function _genSign($method, $url, $arrContent)
	{
    	//$secret_key = $this->_secretKey;
		$opt = array();
		$this->_getKey($opt, self::SECRET_KEY, $this->_secretKey,
                'g_secretKey', 'HTTP_BAE_ENV_SK', 1, 64, false);
		$secret_key = $opt[self::SECRET_KEY];

    	$gather = $method.$url;
    	ksort($arrContent);
    	foreach($arrContent as $key => $value)
   		{
        	$gather .= $key.'='.$value;
    	}
    	$gather .= $secret_key;
    	$sign = md5(urlencode($gather));
    	return $sign;
	}

	protected function _baseControl($opt)
	{
		$content = '';
		$resource = 'channel';
		if (isset($opt[self::CHANNEL_ID]) 
			&& !is_null($opt[self::CHANNEL_ID]) 
			&& !in_array($opt[self::METHOD], $this->_method_channel_in_body)) {
				$resource = $opt[self::CHANNEL_ID];
				unset($opt[self::CHANNEL_ID]);
		}
		$host = $opt[self::HOST];
		unset($opt[self::HOST]);
		
		$url = $host . '/rest/2.0/' . self::PRODUCT . '/';
		$url .= $resource;
		$http_method = 'POST';
		$opt[self::SIGN] = $this->_genSign($http_method, $url, $opt);
		foreach ($opt as $k => $v) {
			$k = urlencode($k);
			$v = urlencode($v);
			$content .= $k . '=' . $v . '&';
		}
		$content = substr($content, 0, strlen($content) - 1);

		$request = new RequestCore($url);
		$headers['Content-Type'] = 'application/x-www-form-urlencoded';
		$headers['User-Agent'] = 'Baidu Channel Service Phpsdk Client';
		foreach ($headers as $headerKey => $headerValue) {
			$headerValue = str_replace(array("\r", "\n"), '', $headerValue);
			if($headerValue !== '') {
				$request->add_header($headerKey, $headerValue);
			}
		}
		$request->set_method($http_method);
		$request->set_body($content);
		if (is_array($this->_curlOpts)) {
			$request->set_curlopts($this->_curlOpts);
		}
		$request->send_request();
		return new ResponseCore($request->get_response_header(),
                $request->get_response_body(),
                $request->get_response_code());
	}

	protected function _channelExceptionHandler($ex)
	{
		$tmpCode = $ex->getCode();
		if (0 === $tmpCode) {
			$tmpCode = self::CHANNEL_SDK_SYS;
		}

		$this->errcode = $tmpCode;
		if ($this->errcode >= 30000) {
			$this->errmsg = $ex->getMessage();
		} else {	
			$this->errmsg = $this->_arrayErrorMap[$this->errcode] . ',detail info['
                    . $ex->getMessage() . ',break point:' . $ex->getFile() . ':'
                    . $ex->getLine() . '].';
		}
	}

	protected function _commonProcess($paramOpt = NULL)
	{
		$this->_adjustOpt($paramOpt);
		$this->_checkParams($paramOpt);
		$ret = $this->_baseControl($paramOpt);
		if (empty($ret)) {
			throw new ChannelException('base control returned empty object',
                    self::CHANNEL_SDK_SYS);
		}
		if ($ret->isOK()) {
			$result = json_decode($ret->body, true);
			if (is_null($result)) {
				throw new ChannelException($ret->body,
                        self::CHANNEL_SDK_HTTP_STATUS_OK_BUT_RESULT_ERROR);
			}
			$this->_requestId = $result['request_id'];
			return $result;
		}
		$result = json_decode($ret->body,true);
		if (is_null($result)) {
			throw new ChannelException('ret body:' . $ret->body,
                    self::CHANNEL_SDK_HTTP_STATUS_ERROR_AND_RESULT_ERROR);
		}
		$this->_requestId = $result['request_id'];
		throw new ChannelException($result['error_msg'], $result['error_code']);
	}

	protected function _mergeArgs($arrNeed, $tmpArgs)
	{
		$arrArgs = array();
		if (0 == count($arrNeed) && 0 == count($tmpArgs)) {
			return $arrArgs;
		}
		if (count($tmpArgs) - 1 != count($arrNeed) && count($tmpArgs) != count($arrNeed)) {
			$keys = '(';
			foreach ($arrNeed as $key) {
                $keys .= $key .= ',';
			}
			if ($keys[strlen($keys) - 1] === '' && ',' === $keys[strlen($keys) - 2]) {
				$keys = substr($keys, 0, strlen($keys) - 2);
			}
			$keys .= ')';
			throw new Exception('invalid sdk params, params' . $keys . 'are needed',
                    self::CHANNEL_SDK_PARAM);
		}
		if( empty($tmpArgs[count($tmpArgs) - 1])){
			$tmpArgs[count($tmpArgs) - 1] = array();
		}		
		if (count($tmpArgs) - 1 == count($arrNeed) && !is_array($tmpArgs[count($tmpArgs) - 1])) {
			throw new Exception('invalid sdk params, optional param must be an array',
                    self::CHANNEL_SDK_PARAM);
		}

		$idx = 0;
		if(!is_null($arrNeed)){
			foreach ($arrNeed as $key) {
				if (!is_integer($tmpArgs[$idx]) && empty($tmpArgs[$idx])) {
					throw new Exception("lack param (${key})", self::CHANNEL_SDK_PARAM);
				}
				$arrArgs[$key] = $tmpArgs[$idx];
				$idx += 1;
			}
		}
		if (isset($tmpArgs[$idx])) {
			foreach ($tmpArgs[$idx] as $key => $value) {
				if ( !array_key_exists($key, $arrArgs) && (is_integer($value) || !empty($value))) {
					$arrArgs[$key] = $value;
				}
			}
		}
		if (isset($arrArgs[self::CHANNEL_ID])) {
			$arrArgs[self::CHANNEL_ID] = urlencode($arrArgs[self::CHANNEL_ID]);
		}
		return $arrArgs;
	}

	protected function _resetErrorStatus()
	{
		$this->errcode = 0;
		$this->errmsg = $this->_arrayErrorMap[$this->errcode];
		$this->_requestId = 0;
	}
}
