<?php
$data_json = file_get_contents('php://input');

$data = json_decode($data_json, true);
$cid = (int)$data['cid'];

include('../../config.php');

$sql = "select Name, Address, Phone_no, Email from CUSTOMER where CID=$cid";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = mysqli_fetch_assoc($result);
$data_json = json_encode($data);
echo $data_json;
?>