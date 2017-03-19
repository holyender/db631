<?php
$data_json = file_get_contents('php://input');

$data = array();

// get room info
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/back_get_rooms.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;
curl_close($ch);
/*
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/back_get_breakfasts.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$breakfasts_json = curl_exec($ch);

curl_close($ch);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/back_get_services.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $breakfasts_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$services_json = curl_exec($ch);
curl_close($ch);

echo $services_json;
*/
?>