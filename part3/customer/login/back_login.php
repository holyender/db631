<?php
  // this file is ment to verify if the user who is trying to log in
  // is a valid customer
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);
//var_dump($data_json);

include('../../config.php');

$email = mysqli_real_escape_string($conn, $data['email']);
$cid = (int)$data['cid'];

$sql = "select * from CUSTOMER where Email='$email' and CID=$cid";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error " . mysqli_error($conn);
  exit;
}

if(1 == mysqli_num_rows($result)){
  $row = mysqli_fetch_assoc($result);
  $name = $row['Name'];

  $data = array("response" => "ack", "name" => $name);
  $data_json = json_encode($data);
  echo $data_json;
}
else{
  $data = array("response" => "nak");
  $data_json = json_encode($data);
  echo $data_json;
}
?>