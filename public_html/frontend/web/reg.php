<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  

 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
 // Populate User name from JSON $obj array and store into $name.
$name = $obj['name'];
 
// Populate User email from JSON $obj array and store into $email.
$email = $obj['email'];
 
// Populate Password from JSON $obj array and store into $password.
$password = $obj['password'];
 
//Checking Email is already exist or not using SQL query.
$CheckSQL = "SELECT * FROM UserRegistrationTable WHERE email='$email'";
 

// where are we posting to?
$url = 'http://size.ir/restapi/orders3';

// what post fields?
$fields = array(
   'field1' => "hhh",
   'field2' => $field2,
);


$data =array("id" =>  $obj['payload']);
$data_string = json_encode($data);

$ch = curl_init('http://size.ir/restapi/orders3');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);


$result = curl_exec($ch);


curl_close($ch);



 
// Converting the message into JSON format.
$json = json_encode($result);
 
// Echo the message.
 echo $json ;
 
 ?>