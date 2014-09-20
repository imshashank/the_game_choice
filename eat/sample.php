<?php
/**
 * Yelp API v2.0 code sample.
 *
 * This program demonstrates the capability of the Yelp API version 2.0
 * by using the Search API to query for businesses by a search term and location,
 * and the Business API to query additional information about the top result
 * from the search query.
 * 
 * Please refer to http://www.yelp.com/developers/documentation for the API documentation.
 * 
 * This program requires a PHP OAuth2 library, which is included in this branch and can be
 * found here:
 *      http://oauth.googlecode.com/svn/code/php/
 * 
 * Sample usage of the program:
 * `php sample.php --term="bars" --location="San Francisco, CA"`
 */

// Enter the path that the oauth library is in relation to the php file
require_once('lib/OAuth.php');

// Set your OAuth credentials here  
// These credentials can be obtained from the 'Manage API Access' page in the
// developers documentation (http://www.yelp.com/developers)
$CONSUMER_KEY = "aPozCcQK-3xJIDirPNBfng";
$CONSUMER_SECRET = "7-k4Dtup0MguZH-teqqmoDfm1NY";
$TOKEN = "MiCGJH-pw1hy3Vs2E6rOQmhigfK6Padt";
$TOKEN_SECRET = "AmW_nqF-P907Epj5bKurcW3jRHw";


$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = $_GET['term'];
#$DEFAULT_LOCATION = $_GET['city'];
#echo $DEFAULT_LOCATION;
$DEFAULT_LOCATION = 'San Francisco, CA';
$SEARCH_LIMIT = 10;
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';
//$DEFAULT_OFFSET= 10;





/** 
 * Makes a request to the Yelp API and returns the response
 * 
 * @param    $host    The domain host of the API 
 * @param    $path    The path of the APi after the domain
 * @return   The JSON response from the request      
 */
function request($host, $path) {
    $unsigned_url = "http://" . $host . $path;

    // Token object built using the OAuth library
    $token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);

    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);

    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer, 
        $token, 
        'GET', 
        $unsigned_url
    );
    
    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);
    
    // Get the signed URL
    $signed_url = $oauthrequest->to_url();
    
    // Send Yelp API Call
    $ch = curl_init($signed_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}

/**
 * Query the Search API by a search term and location 
 * 
 * @param    $term        The search term passed to the API 
 * @param    $location    The search location passed to the API 
 * @return   The JSON response from the request 
 */
function search($term, $location) {
    $url_params = array();
    
    $url_params['term'] = $term ?: $GLOBALS['DEFAULT_TERM'];
    //$url_params['offset'] = $GLOBALS['DEFAULT_OFFSET'];
    $url_params['location'] = $location?: $GLOBALS['DEFAULT_LOCATION'];
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
    
    return request($GLOBALS['API_HOST'], $search_path);
}

/**
 * Query the Business API by business_id
 * 
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request 
 */
function get_business($business_id) {
    $business_path = $GLOBALS['BUSINESS_PATH'] . $business_id;
    
    return request($GLOBALS['API_HOST'], $business_path);
}

/**
 * Queries the API by the input values from the user 
 * 
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function query_api($term, $location) {     
    $response = json_decode(search($term, $location));

$business_id=array();
for($x=0;$x<count($response->businesses);$x++)
    {
$business_id[$x] = $response->businesses[$x]->id;
}


 $name=array();
for($a=0;$a<count($response->businesses);$a++)
    {
$name[$a] = $response->businesses[$a]->name;
}

$rating=array();
for($a1=0;$a1<count($response->businesses);$a1++)
    {
$rating[$a1] = $response->businesses[$a1]->rating;
}

$display_phone=array();
for($a2=0;$a2<count($response->businesses);$a2++)
    {
$display_phone[$a2] = $response->businesses[$a2]->display_phone;
}

    $review_count=array();
for($a3=0;$a3<count($response->businesses);$a3++)
    {
$review_count[$a3] = $response->businesses[$a3]->review_count;
}
$url=array();
for($a4=0;$a4<count($response->businesses);$a4++)
    {
$url[$a4] = $response->businesses[$a4]->url;
}
$display_address=array();
for($a5=0;$a5<count($response->businesses);$a5++)
    {
$display_address[$a5] = $response->businesses[$a5]->location->display_address;
}

    
    /*print sprintf(
        "%d businesses found \"%s\"\n\n",         
        count($response->businesses)
        
    );*/
	$response=array();
    for($y=0;$y<10;$y++)
   { $response[$y] = get_business($business_id[$y]);}
    
 $result = array();


    for($z=0;$z<10;$z++)
    {
//print sprintf("Result for business \"%s\" found:\n", $business_id[$z]);
//echo $display_address[$z][0];
 //  print "{$name[$z]} \n";
   
  // print "{$display_address[$z][0]} \n";
//print "{$display_phone[$z]} \n";
//print "{$rating[$z]} \n";
//print "{$review_count[$z]} \n";
//print "{$url[$z]} \n";
//print "\n\n";

$result['title'][$z]['name']=$name[$z];
$result['title'][$z]['address']=$display_address[$z][0];
$result['title'][$z]['phone']=$display_phone[$z];
$result['title'][$z]['count']=$review_count[$z];
$result['title'][$z]['url']=$url[$z];
}

$link = 'http://108.61.131.41/the_game_choice/places/?topic=bar'.$_GET['term'];

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);       
        curl_close($ch);
        #var_dump($output);
        
        $res = json_decode($output, true);
        $cat = ($res['categories']);
        
        $i = 0;
        foreach($cat as $x){
            $result['categories'][$i]=$x;
            $i  =$i+1;
        }
/*$post_data=array(
'value'=>array(
 'name'=>$name[$z],
'display_address'=>$display_address[$z][0],
'display_phone'=>$display_phone[$z],
'rating'=>$rating[$z],
'review_count'=>$review_count[$z],
'url'=>$url[$z]
));

echo json_encode($post_data);  */

	

        #var_dump($res->categories);
        #var_dump( $res['categories'] );

  echo json_encode($result);

}

/**
 * User input is handled here 
 */

$longopts  = array(
    "term::",
    "location::",
);
    
$options = getopt("", $longopts);

$term = $options['term'] ?: '';
$location = $options['location'] ?: '';

query_api($term, $location);




        
?>
