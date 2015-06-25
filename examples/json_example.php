<?php
/*
*	This is an example of how to request data from index.php
*	PULL REQUEST BY: Woo Huiren (woohuiren.me)
*
*/
	$websiteUrl = 'https://www.example.com'; //the URL of your website

	$ch = curl_init();
	$data = array('type' => 'json');
	$options = array(
		CURLOPT_URL => $websiteUrl . "/index.php",
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $data
	);
	curl_setopt_array($ch, $options);
	$contents = curl_exec($ch); //execute CURL action
	curl_close($ch); //close the CURL connection
	var_dump($content); //dump the content
?>