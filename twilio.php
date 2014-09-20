<?php
require './twilio-php-master/twilio-php/Services/Twilio.php';
// Your Account Sid and Auth Token from twilio.com/user/account
$sid = "AC30026988f42fe55f7e6c590a9d91a529"; 
$token = "b0f13a2539abf3dfeca4868b34df54c4"; 
$client = new Services_Twilio($sid, $token);
 
$client->account->messages->sendMessage("+14158141829", "+15558675309", "Jenny please?! I love you <3", "http://www.example.com/hearts.png");
?>
