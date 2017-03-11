<?php
$data_json = file_get_contents('php://input');

$data = json_decode($data_json, true);
$cid = (int)$data['cid'];

include('../config.php');

$sql = "select InvoiceNo from RESERVATION where CID=$cid";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "querry error: " . mysqli_error($conn);
  exit;
}

$count_reservations = mysqli_num_rows($result);
$reservations = array();
for($i=0; $i < $count_reservations; $i++){
  
}
?>