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
include('../places/vendor/autoload.php');

require_once('lib/OAuth.php');

// Set your OAuth credentials here  
// These credentials can be obtained from the 'Manage API Access' page in the
// developers documentation (http://www.yelp.com/developers)
$CONSUMER_KEY = "aPozCcQK-3xJIDirPNBfng";
$CONSUMER_SECRET = "7-k4Dtup0MguZH-teqqmoDfm1NY";
$TOKEN = "MiCGJH-pw1hy3Vs2E6rOQmhigfK6Padt";
$TOKEN_SECRET = "AmW_nqF-P907Epj5bKurcW3jRHw";


$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = $_GET['types'];



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
    
    $url_params['types'] = $term ?: $GLOBALS['DEFAULT_TERM'];
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

$link = 'http://nimit.me/the_game_choice/categorize.php/?text='.$_GET['types'];

        $curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $link,
));
// Send the request & save response to $resp
$output = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
        #var_dump($output);
        
        $cat = json_decode($output, true);
       # $cat = ($res['categories']);
        #var_dump($cat);
    
        $pre = str_replace("%20", "&", $_GET["pre"]);
        #var_dump($_GET["pre"]);
        $pre = str_replace(" ", "-", $_GET["pre"]);
        $pre_a =  explode('&',$pre);



$pre_arr=array();

for ($i = 0;$i<count($pre_a);$i++){
    $pre_arr[$pre_a[$i]]= True;
}

        foreach($cat as $x => $y){
            if(!isset($pre_arr[$x])){
            $result['categories'][]=$x;
            $i  =$i+1;
        }
        }

        if($_GET['types'] == 'food'){
            $result['categories']['0']='Indian';
            $result['categories']['1']='Spicy';
            $result['categories']['2']='Mexican';
            $result['categories']['3']='American';
            $result['categories']['4']='Junk';
            $result['categories']['5']='Thai';
            $result['categories']['6']='Just Good';
            $result['categories']['6']='Simple';

        }

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



//if (isset($_POST["types"])){
    #echo $type_post;

//  get_places('-33.86820', '151.1945860', '800',$type_post);
//}

header('Content-Type: application/json');

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

$term = $options['types'] ?: '';
$location = $options['location'] ?: '';

query_api($term, $location);




        
?>