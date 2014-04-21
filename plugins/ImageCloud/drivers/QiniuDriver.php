<?php

class QiniuDriver
{
	const UP_HOST = 'http://up.qiniu.com';

	public $accessKey;
	public $secretKey;
	public $bucket;

	function __construct()
	{
		$this->accessKey = C('Plugins.ImageCloud.Qiniu.AccessKey');
		$this->secretKey = C('Plugins.ImageCloud.Qiniu.SecretKey');
		$this->bucket = C('Plugins.ImageCloud.Qiniu.Bucket');
	}

	public function getTokens()
	{
		$expire = C('Plugins.ImageCloud.Qiniu.Expire',3600);
		$deadline = $expire + time();
		$flags = array(
			'deadline' => $deadline,
			'scope' => $this->bucket,
		);
		$encodedFlags = self::urlsafe_base64_encode(json_encode($flags));
		$sign = hash_hmac('sha1', $encodedFlags, $this->secretKey, true);
		$encodedSign = self::urlsafe_base64_encode($sign);
	    $token = $this->accessKey.':'.$encodedSign. ':' . $encodedFlags;
	    return array('token'=>$token);
	}

	public function getUploadUrl()
	{
		return self::UP_HOST;
	}

	public function getRootUrl()
	{
		return C('Plugins.ImageCloud.Qiniu.RootUrl',"http://{$this->bucket}.qiniudn.com/");
	}

	public function getSuffix()
	{
		return C('Plugins.ImageCloud.Qiniu.Suffix');
	}

	public static function urlsafe_base64_encode($str){
	    $find = array("+","/");
	    $replace = array("-", "_");
	    return str_replace($find, $replace, base64_encode($str));
	}
}