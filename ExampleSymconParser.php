<?php
 
//API Url
$url = 'https://vrmapi.victronenergy.com/v2/auth/login';
 
//Initiate cURL.
$ch = curl_init($url);
 
//The JSON data.
$jsonData = array(
    'username' => '<UNSERNAME>',
    'password' => '<PASSWORD>'
);
 
//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);
 
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, false);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
//Execute the request
$response =  json_decode(curl_exec($ch), true);
//print_r($response);
$token = $response['token'];
$idUser = $response['idUser'];


//$url1 = 'https://vrmapi.victronenergy.com/v2/installations/<INSTALLATION_ID>/system-overview';
$url1 = 'https://vrmapi.victronenergy.com/v2/users/'.$idUser.'/installations?extended=1';


//Initiate cURL.
$ch1 = curl_init($url1);

//Set the content type to application/json
//echo $url1;
//echo $token;

$authorization = "X-Authorization: Bearer " . $token;

curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_VERBOSE, false);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));  

//Execute the request
$resultVRM = json_decode(curl_exec($ch1), true);
//print_r($resultVRM);

SetValueFloat(	21366,$resultVRM['records']['0']['extended']['4']['rawValue']);
SetValueFloat(	21442,$resultVRM['records']['0']['extended']['3']['rawValue']);
SetValueString(	10326,$resultVRM['records']['0']['extended']['6']['formattedValue']);



$url1 = 'https://vrmapi.victronenergy.com/v2/installations/<INSTALLATION_ID>/overallstats';

//Initiate cURL.
$ch1 = curl_init($url1);

//Set the content type to application/json
//echo $url1;
//echo $token;

$authorization = "X-Authorization: Bearer " . $token;

curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_VERBOSE, false);
curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));  

//Execute the request
$resultVRM = json_decode(curl_exec($ch1), true);
//print_r($resultVRM);


SetValueFloat( 17964,$resultVRM['records']['today']['totals']['total_solar_yield']);
