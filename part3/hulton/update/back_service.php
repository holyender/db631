<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);
//var_dump($data);

include('../../config.php');

$old_hotelid = (int)$data['old_hotelid'];
$new_hotelid = (int)$data['new_hotelid'];
$old_stype = mysqli_real_escape_string($conn, $data['old_stype']);
$new_stype = mysqli_real_escape_string($conn, $data['new_stype']);
$old_sprice = (float)$data['old_sprice'];
$new_sprice = (float)$data['new_sprice'];

$sql = "update SERVICE set HotelID=$new_hotelid, SType='$new_stype', SPrice=$new_sprice where HotelID=$old_hotelid and SType='$old_stype'";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

?>