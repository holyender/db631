<?php
$data_json = file_get_contents('php://input');

// check if the room is available during the check in and out period
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/back_is_avail.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result_json = curl_exec($ch);

curl_close($ch);

$result = json_decode($result_json, true);

if(isset($result['response'])){
  $result_json = json_encode($result);
  echo $result_json;
  exit;
}

if(!$result['avail']){
  $result = array("response" => "room not available");
  $result_json = json_encode($result);
  echo $result_json;
  exit;
}

// if it's available, get the services and breakfasts available for that hotel
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/back_get_breakfasts_services.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

echo $result;

?>