<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

$url = "";
if(strcmp($data['info'], "services") == 0){
  $url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/info/back_get_services.php";
}
else if(strcmp($data['info'], "rooms") == 0){
  $url = "http://afsaccess.njit.edu/~jjl37/database/part3/hulton/info/back_get_rooms.php";
}
else if(strcmp($data['info'], "breakfast") == 0){
  $url = "http://afsaccess.njit.edu/~jjl37/database/part3/hulton/info/back_get_breakfasts.php";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;

?>