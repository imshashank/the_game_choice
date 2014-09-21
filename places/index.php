<?php

include('vendor/autoload.php');

$final_answer = array();

$pre = str_replace("%20", "&", $_GET["pre"]);
$pre = str_replace(" ", "&", $_GET["pre"]);


$type_post = $_GET["types"];
$type_post = str_replace("%20", "&", $type_post);
$type_post = str_replace(" ", "&", $type_post);

$res_temp_1 = array();
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
        
        $res_temp_1 = json_decode($output, true);
         $res_temp =($res_temp_1);
       #var_dump($res_temp);

      $res_final = array();

       foreach ($res_temp as $x => $y){

       	$res_final[]=$x;
       }
        
        
        
$res_temp = implode(' ',$res_final);


$res_temp = str_replace("%20", "&", $res_temp);
$res_temp = str_replace(" ", "|", $res_temp);

$type_post = $type_post.'&'.$pre.'&'.$res_temp;

#echo $type_post;
get_places('33.7489954', '-84.3879824', '800',$type_post,$res_temp_1);

//if (isset($_POST["types"])){
	#echo $type_post;

//	get_places('-33.86820', '151.1945860', '800',$type_post);
//}

$topics=array();

function get_places($lat, $long, $radius, $types, $res_temp_1){
$google_places = new joshtronic\GooglePlaces('AIzaSyARM9C4EtyNYH0mSk-iyUtAoEnj_8Yrixs');
$google_places->location = array($lat, $long);
$google_places->radius   = $radius;
$google_places->output   ='json';
$google_places->keyword    = $types;
$results                 = $google_places->nearbySearch();

$r = $results['results'];

#var_dump($r);

#$res_final = explode(' ' ,$res_final);
#var_dump($res_temp_1);
foreach ($r as $x){
	$x = $x['types'];
	foreach ($x as $y){
		if ($topics[$y]!= ''){
			$topics[$y] = $topics[$y] +1;
		}
		else
			$topics[$y] = 1;
	}

	foreach ($res_temp_1 as $a => $b){
		#echo $a;
		if ($topics[$a]!= ''){
			$topics[$a] = $topics[$a] +1;
		}
		else
			$topics[$a] = 1;
	}
	#var_dump($x['types']);
}

#echo "something";

arsort($topics);


#array_push($temp, "tourist destinations", "budget travel", "adventure","leisure","trekking","sightseeing");

#shuffle($topics);
#
#$temp = $topics;
foreach($topics as $x => $y){
	$temp[] =$x;
}
$topics = $temp;
#$topics = array_slice($temp, 0, 7);

$pre = str_replace("%20", "&", $_GET["pre"]);
$pre = str_replace(" ", "&", $_GET["pre"]);
$pre_a =  explode('&',$pre);



$pre_arr=array();

for ($i = 0;$i<count($pre_a);$i++){
	$pre_arr[$pre_a[$i]]= True;
}

#var_dump($pre_arr);
for ($i =0; $i < count($topics);$i++){
#echo $topics[$i];
if($topics[$i] != null && !isset($pre_arr[$topics[$i]])){

	$final_answer['categories'][]=$topics[$i];

}

	#echo '<form action="'.$PHP_SELF.'" method = "GET"><input type="hidden" name="types" value="'.$key.'"><button type="submit">'.$key.' </button></form>';

}
	#var_dump($final_answer);

$i = 0;
foreach ($r as $x){
	#var_dump($x);
	$final_answer['title'][$i]['name'] = $x['name'];
	$final_answer['title'][$i]['icon'] = $x['icon'];
	$final_answer['title'][$i]['lat'] = $x['geometry']['location']['lat'];
	$final_answer['title'][$i]['lng'] = $x['geometry']['location']['lng'];
	$final_answer['title'][$i]['vicinity'] = $x['vicinity'];
	$i =$i +1;
	#echo '<tr><td>'.$x['name'].'</td></tr>';
	
}
	$answer = json_encode($final_answer);
	header('Content-Type: application/json');
	echo $answer;
#var_dump( $answer);


}



?>



