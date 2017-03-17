<?php

$data_json = file_get_contents("php://input");
//var_dump($data_json);
$data = json_decode($data_json, true);

include("../config.php");

$name = mysqli_real_escape_string($conn, $data['name']);
$address = mysqli_real_escape_string($conn, $data['address']);
$phone_no = mysqli_real_escape_string($conn, $data['phone_no']);
$email = mysqli_real_escape_string($conn, $data['email']);

$sql = "insert into CUSTOMER (NAME, ADDRESS, Phone_no, Email) values ('$name', '$address', '$phone_no', '$email')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "select max(CID) from CUSTOMER";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$result = mysqli_fetch_assoc($result);
$cid = $result['max(CID)'];

$message = "CID: " . $cid;
$to = $email;
$subject = "Hotel Registration CID";

mail($to, $subject, $message);

$data = array("response" => "ack");
$data_json = json_encode($data);
echo $data_json;

?>