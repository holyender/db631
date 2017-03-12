<?php
$email = $_POST['email'];
$cid = $_POST['cid'];

$data = array("email" => $email, "cid" => $cid);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/back_login.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
//echo $result;
$response = json_decode($result, true);

if(strcmp($response['response'], "ack") == 0){
  session_start();
  $_SESSION['email'] = $email;
  $_SESSION['name'] = $response['name'];
  $_SESSION['cid'] = $cid;
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/customer/homepage.php");
}
else{
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/login.php?login_fail=invalid");
}

?>