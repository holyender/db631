<?php

$name = $_POST['name'];
$address = $_POST['address'];
$phone_no = $_POST['phone_no'];
$email = $_POST['email'];

$data = array("name" => $name, "address" => $address, "phone_no" => $phone_no, "email" => $email);

$data_json = json_encode($data);

$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/registration/back_register.php";

$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

echo $result;

?>