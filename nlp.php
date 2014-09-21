<?php
	require_once 'alch/alchemyapi.php';
	$alchemyapi = new AlchemyAPI();
	$demo_text = $_GET['text'];

$result = array();
$response = $alchemyapi->taxonomy('text',$demo_text, null);

	if ($response['status'] == 'OK') {
		#echo '## Response Object ##', PHP_EOL;
		#echo print_r($response);

		#echo PHP_EOL;
		#echo '## Categories ##', PHP_EOL;
		$i =0;
		foreach ($response['taxonomy'] as $category) {
			$x = explode('/',$category['label']);
			foreach ($x as $y){
				if($result[$y] == '' && $y != ''){
					$result[$y]=$category['score'];
				}

				
			}
			
			$i = $i +1;
		  #echo $category['label'], ' : ', $category['score'], PHP_EOL;
		}
	} else {
		#echo 'Error in the taxonomy call: ', $response['statusInfo'];
	}

$result = array();

$link = 'http://nimit.me/the_game_choice/places/?types='.$_GET[implode(" ",$result)];

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);       
        curl_close($ch);
        #var_dump($output);
        echo $output;
        #$res = json_decode($output, true);
#echo json_encode($result);


?>
