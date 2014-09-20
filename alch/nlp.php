<?php
	require_once 'alchemyapi.php';
	$alchemyapi = new AlchemyAPI();
	$demo_text = 'Yesterday dumb Bob destroyed my fancy iPhone in beautiful Denver, Colorado. I guess I will have to head over to the Apple Store and buy a new one.';

$response = $alchemyapi->category('text',$demo_text, null);

	if ($response['status'] == 'OK') {
		echo print_r($response);

		echo 'category: ', $response['category'], PHP_EOL;
		echo 'score: ', $response['score'], PHP_EOL;
	} else {
		echo 'Error in the text categorization call: ', $response['statusInfo'];
	}

?>
