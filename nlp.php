<?php
	require_once 'alchemyapi_php/alchemyapi.php';
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

echo json_encode($result);


?>