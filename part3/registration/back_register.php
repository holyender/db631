<?php

$data_json = file_get_contents("php://input");
//var_dump($data_json);

$data = json_decode($data_json, true);
$name = $data['name'];
$address = $data['address'];
$phone_no = $data['phone_no'];
$email = $data['email'];

include("../config.php");

$sql = "create table if not exists CUSTOMER (CID int auto_increment, NAME varchar(16), ADDRESS varchar(16), Phone_no char(10), Email varchar( 16), constraint customerpk primary key(CID))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

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