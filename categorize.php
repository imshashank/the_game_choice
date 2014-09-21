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
				if(!isset($result[$y]) && $y != ''){
					$result[$y]=$category['score'];
				}

				
			}
			
			$i = $i +1;
		  #echo $category['label'], ' : ', $category['score'], PHP_EOL;
		}
	} 


        #$res = json_decode($output, true);
echo json_encode($result);


?>
