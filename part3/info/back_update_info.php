<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

$name = $data['name'];
$address = $data['address'];
$phone_no = $data['phone_no'];
$email = $data['email'];

include('../config.php');

if(!empty($name)){
  $sql = "update CUSTOMER";
}
?>