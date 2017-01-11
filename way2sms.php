<?php

/**
* 
*/
class Way2Sms
{	
	//user name of Way2Sms service 
	public static $username ;
	// password of Way2Sms service
	public static $password ;
	//token 
	public static $token;

	function __construct($user  , $pass)
	{
		Way2Sms::$username = $user;
		Way2Sms::$password = $pass;
	}
	function init()
	{  
	  	$postData = '';
	  	$url      = "http://site24.way2sms.com/Login1.action";
	  	$params	  = array('username'=>Way2Sms::$username,'password'=>Way2Sms::$password);
	   //create name value pairs seperated by &
	   foreach($params as $k => $v) 
	   { 
	      $postData .= $k . '='.$v.'&'; 
	   }
	    $postData = rtrim($postData, '&');
	    $ch = curl_init();  
	    curl_setopt($ch,  CURLOPT_URL,$url);
	    curl_setopt($ch,  CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,  CURLOPT_HEADER,true); 
	    curl_setopt($ch,  CURLOPT_POST, count($postData));
	    curl_setopt($ch,  CURLOPT_POSTFIELDS, $postData); 
	  $tmpfname = dirname(__FILE__)."/cookies/cookiefile";
	    curl_setopt($ch,  CURLOPT_COOKIEJAR, $tmpfname);
	    curl_setopt($ch,  CURLOPT_COOKIEFILE, $tmpfname);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    // get cookie, all cos sometime set-cookie could be more then one
	    preg_match_all('/^Set-Cookie:\s*([^\r\n]*)/mi', $result, $ms); 
	    $cookies = array();
	    foreach ($ms[1] as $m) {
	        list($name, $value) = explode('=', $m, 2);
	        $cookies[$name] = $value;
	    }
	    $coo = explode(";",$cookies["JSESSIONID"]);
	    $str = preg_replace("/^((.)*~)/", "", $coo[0]);
	    Way2Sms::$token= $str;
	}

	//function to send message to a mobile number 
	//first call httpPost() before calling this function
	function sendMessage($mobile,$message){
     $postData = '';
     $params=array('Token' =>Way2Sms::$token,'mobile'=>$mobile,'name'=>"Sender",'ssaction'=>"qs",'message'=>$message,'msgLen'=>4 );
     //create name value pairs seperated by &
     foreach($params as $k => $v) 
     { 
        $postData .= $k . '='.$v.'&'; 
     }
    $postData = rtrim($postData, '&');
    $url = "http://site24.way2sms.com/smstoss.action";
    $ch = curl_init();
    curl_setopt($ch,  CURLOPT_URL,$url);
    curl_setopt($ch,  CURLOPT_HEADER,true); 
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,  CURLOPT_POST, count($postData));
    curl_setopt($ch,  CURLOPT_POSTFIELDS, $postData); 
    $tmpfname = dirname(__FILE__)."/cookies/cookiefile";
    curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
    $result = curl_exec($ch); 
    unlink("cookies/cookiefile");
    curl_close($ch);
	}
}