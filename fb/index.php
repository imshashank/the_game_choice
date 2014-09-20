<?php 
require_once './vendor/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;

session_start();
FacebookSession::setDefaultApplication('390445034339844', '8fd44c794360a8528173611ff4a8a5cc');


#FacebookSession::setDefaultApplication('apid', 'appscret');
$helper = new FacebookRedirectLoginHelper("http://108.61.131.41/the_game_choice/fb/index.php", $apiVersion = NULL);
try {
    $session = $helper->getSessionFromRedirect();
} catch (FacebookRequestException $ex) {
    // When Facebook returns an error
} catch (\Exception $ex) {
    // When validation fails or other local issues
}
if (isset($session)) {

    $request = new FacebookRequest($session, 'GET', '/me/interests/');
    $response = $request->execute();
    $graphObject = $response->getGraphObject();
    var_dump($graphObject);
   
  

} else {
    echo '<a href="' . $helper->getLoginUrl() . '">Login with Facebook</a>';
}

?>