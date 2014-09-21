<?php
require 'src/facebook.php';  // Include facebook SDK file
//require 'functions.php';  // Include functions
$facebook = new Facebook(array(
  'appId'  => '1545402332359139',   // Facebook App ID 
  'secret' => '3150647ac9022d01026fad806591e123',  // Facebook App Secret
  'cookie' => true, 
));
$user = $facebook->getUser();
#if(isset($_GET['code'])){
#header("Location: index.php");
#}
if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  	    $fbid = $user_profile['id'];                 // To Get Facebook ID
 	    $fbuname = $user_profile['username'];  // To Get Facebook Username
 	    $fbfullname = $user_profile['name']; // To Get Facebook full name
	    $femail = $user_profile['email'];  
      $user_interests= $facebook->api('/me/likes/');


      $file = 'people.txt';
// Open the file to get existing content
// Append a new person to the file
#$current .= "John Smith\n";
// Write the contents back to the file
file_put_contents($file, $user_interests);

      var_dump($user_interests);// To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
	    $_SESSION['USERNAME'] = $fbuname;
            $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
#           checkuser($fbid,$fbuname,$fbfullname,$femail);    // To update local DB
  } catch (FacebookApiException $e) {
    error_log($e);
   $user = null;
  }
}

?>
