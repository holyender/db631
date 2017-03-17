<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$old_hotelid = (int)$data['old_hotelid'];
$new_hotelid = (int)$data['new_hotelid'];
$old_roomno = (int)$data['old_roomno'];
$new_roomno = (int)$data['new_roomno'];
$old_rtype = mysqli_real_escape_string($conn, $data['old_rtype']);
$new_rtype = mysqli_real_escape_string($conn, $data['new_rtype']);
$old_price = (float)$data['old_price'];
$new_price = (float)$data['new_price'];
$old_description = mysqli_real_escape_string($conn, $data['old_description']);
$new_description = mysqli_real_escape_string($conn, $data['new_description']);
$old_floor = (int)$data['old_floor'];
$new_floor = (int)$data['new_floor'];
$old_capacity = (int)$data['old_capacity'];
$new_capacity = (int)$data['new_capacity'];

$sql = "update ROOM set HotelID=$new_hotelid, RoomNo=$new_roomno, Rtype='$new_rtype', Price=$new_price, Description='$new_description', Floor=$new_floor, Capacity=$new_capacity where HotelID=$old_hotelid and RoomNo=$old_roomno";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

?>