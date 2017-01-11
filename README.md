# way2SMS_API
Send message from Command Line or from a Web App for free using easy to use API.


Example for using the Library

<?php
require_once("way2sms.php");


$sms = new Way2Sms("userofWay2Sms","passwordOfWay2Sms");


$sms->init();


// mobile number on which message is being sent 


$mobile = "9461426263";


//your message


$message = "hey there!!!";


//send  message


$sms->sendMessage($mobile,$message);


?>
