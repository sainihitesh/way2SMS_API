<?php

//test 

require_once("way2sms.php");

$sms = new Way2Sms("userofWay2Sms","passwordOfWay2Sms");
$sms->init();
// mobile number on which message is being sent 
$mobile = "9461426263";
//your message
$message = "hey there!!!";
//send  message
$sms->sendMessage($mobile,$message);