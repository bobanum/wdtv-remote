<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//
$data = file_get_contents("php://input");
//$data = http_build_query($_POST);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://192.168.1.106/cgi-bin/toServerValue.cgi");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

echo $server_output;
