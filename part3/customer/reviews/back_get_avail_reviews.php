<?php
  // this file is ment to return which room reviews a customer can make
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$cid = (int)$data['cid'];

$sql = "select ROOM_RESERVATION.HotelID, ROOM_RESERVATION.RoomNo from ROOM_RESERVATION where ROOM_RESERVATION.InvoiceNo in (select RESERVATION.InvoiceNo from RESERVATION where RESERVATION.CID=$cid)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();

$count_rooms = mysqli_num_rows($result);
for($i=0; $i < $count_rooms; $i++){
  $room = mysqli_fetch_row($result);
  array_push($data, $room);
}

$data_json = json_encode($data);
echo $data_json;

?>