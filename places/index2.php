<?php

include('vendor/autoload.php');

$final_answer = array();

$type_post = $_GET["types"];
$type_post = str_replace("%20", "&", $type_post);
$type_post = str_replace(" ", "&", $type_post);
#echo $type_post;
get_places('33.7489954', '-84.3879824', '800',$type_post);

//if (isset($_POST["types"])){
	#echo $type_post;

//	get_places('-33.86820', '151.1945860', '800',$type_post);
//}

$topics=array();

function get_places($lat, $long, $radius, $types){
$google_places = new joshtronic\GooglePlaces('AIzaSyARM9C4EtyNYH0mSk-iyUtAoEnj_8Yrixs');
$google_places->location = array($lat, $long);
$google_places->radius   = $radius;
$google_places->output   ='json';
$google_places->keyword    = $types;
$results                 = $google_places->nearbySearch();

$r = $results['results'];

#var_dump($r);

foreach ($r as $x){
	$x = $x['types'];
	foreach ($x as $y){
		if ($topics[$y]!= ''){
			$topics[$y] = $topics[$y] +1;
		}
		else
			$topics[$y] = 1;
	}
	#var_dump($x['types']);
}



arsort($topics);

$output = array_slice($topics, 0, 5);
array_push($output, "tourist destinations", "budget travel","camping", "adventure","leisure","trekking","sightseeing");
shuffle($output);
#$output = array_slice($output, 0, 6);
$i = 0;
foreach ($output as $key => $value){

	$final_answer[$i]=$value;
	#echo $value;
	#$final_answer['categories']=$key;

	$i =$i +1;
	#echo '<form action="'.$PHP_SELF.'" method = "GET"><input type="hidden" name="types" value="'.$key.'"><button type="submit">'.$key.' </button></form>';

}
var_dump($final_answer);
$json_answer = json_encode($final_answer);
	echo $json_answer;
	#var_dump($final_answer);



}



?>


