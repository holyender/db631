<?php
$email = $_POST['email'];
$cid = $_POST['cid'];

$data = array("email" => $email, "cid" => $cid);
$data_json = json_encode($data);

$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/login/back_login.php";

$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

$response = json_decode($result, true);

if(strcmp($response['response'], "ack") == 0){
  session_start();
  $_SESSION['email'] = $email;
  $_SESSION['name'] = $response['name'];
  $_SESSION['cid'] = $cid;
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/homepage.php");
}
else{
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/login/index.php?login_fail=invalid");
}
?>