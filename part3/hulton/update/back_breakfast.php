<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$old_hotelid = (int)$data['old_hotelid'];
$new_hotelid = (int)$data['new_hotelid'];
$old_btype = mysqli_real_escape_string($conn, $data['old_btype']);
$new_btype = mysqli_real_escape_string($conn, $data['new_btype']);
$old_bprice = (float)$data['old_bprice'];
$new_bprice = (float)$data['new_bprice'];
$old_description = mysqli_real_escape_string($conn, $data['old_description']);
$new_description = mysqli_real_escape_string($conn, $data['new_description']);

$sql = "update BREAKFAST set HotelID=$new_hotelid, BType='$new_btype', BPrice=$new_bprice, Description='$new_description' where HotelID=$old_hotelid and BType='$old_btype'";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

?>