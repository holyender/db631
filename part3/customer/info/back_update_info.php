<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

$cid = (int)$data['cid'];
$name = $data['name'];
$address = $data['address'];
$phone_no = $data['phone_no'];
$email = $data['email'];

include('../../config.php');

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