<?php
$body = $_REQUEST['Body'];

#$body ="random pizza";
$link = 'http://108.61.131.41/the_game_choice/places/index.php?types='.$body;

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

$output = json_decode($output, true);

#var_dump($output);
header("content-type:text/xml");
#$i = 0;
$a= '';
for ($i =0;$i<count($output['title'])-1;$i++ ){
if($i > 5){break;}
$a.= "$i .".$output['title'][$i]['name'];
$a.= 'A:'.$output['title'][$i]['vicinity'].'';
$a.= $i.' '.$x['name'][$i].' '.$x['vicinity']. ' ';
#$i = $i +1;
}
$a = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $a);
echo '<?xml version="1.0" encoding="UTF-8"?>
<Response><Message>.'; 
echo $a; 
echo '.</Message>

</Response>';
/*echo '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Message>';
for ($i =0;$i<count($output['title']);$i++ ){
echo "$i .".$output['title'][$i]['name'];
echo ' A:'.$output['title'][$i]['vicinity'].'
 ';
if ($i > 4){
break;}
}
echo '</Message>

</Response>';


*/

?>
