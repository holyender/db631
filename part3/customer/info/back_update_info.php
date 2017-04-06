<?php
  // this file is ment to update the customer's information
  // if any of the fields are empty, the information will not be updated
  // only nonempty information will be updated
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$cid = (int)$data['cid'];
$name = mysqli_real_escape_string($conn, $data['name']);
$address = mysqli_real_escape_string($conn, $data['address']);
$phone_no = mysqli_real_escape_string($conn, $data['phone_no']);
$email = mysqli_real_escape_string($conn, $data['email']);

if(!empty($name)){
  $sql = "update CUSTOMER set Name='$name' where CID=$cid";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

if(!empty($address)){
  $sql = "update CUSTOMER set Address='$address' where CID=$cid";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

if(!empty($phone_no)){
  $sql = "update CUSTOMER set Phone_no='$phone_no' where CID=$cid";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

if(!empty($email)){
  $sql = "update CUSTOMER set Email='$email' where CID=$cid";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}
?>