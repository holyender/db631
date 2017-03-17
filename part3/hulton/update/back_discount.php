<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$old_hotelid = (int)$data['old_hotelid'];
$new_hotelid = (int)$data['new_hotelid'];
$old_roomno = (int)$data['old_roomno'];
$new_roomno = (int)$data['new_roomno'];
$old_discount = (float)$data['old_discount'];
$new_discount = (float)$data['new_discount'];
$old_startdate = mysqli_real_escape_string($conn, $data['old_startdate']);
$new_startdate = mysqli_real_escape_string($conn, $data['new_startdate']);
$old_enddate = mysqli_real_escape_string($conn, $data['old_enddate']);
$new_enddate = mysqli_real_escape_string($conn, $data['new_enddate']);

$sql = "update DISCOUNTED_ROOM set HotelID=$new_hotelid, RoomNo=$new_roomno, Discount=$new_discount, StartDate='$new_startdate', EndDate='$new_enddate' where HotelID=$old_hotelid and RoomNo=$old_roomno";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

?>