<?php
$data_json = file_get_contents('php://input');

// check if the room is available during the check in and check out period
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/back_is_avail.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result_json = curl_exec($ch);

curl_close($ch);
//echo $result_json;

$result = json_decode($result_json, true);

// if the room is not available then return an error message and exit
if(strcmp($result['response'], "not available") == 0){
  echo $result_json;
  exit;
}

// if it's available, get the services and breakfasts
// available for that hotel
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/back_get_breakfasts_services.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo $result;

?>