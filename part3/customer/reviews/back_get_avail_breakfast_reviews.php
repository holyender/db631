<?php
  // this file is ment to return the available breakfast reviews
  // a customer can make given their cid
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json, true);

include('../../config.php');

$cid = (int)$data['cid'];

$sql = "select HotelID, Btype from RRESV_BREAKFAST where (RRESV_BREAKFAST.HotelID, RRESV_BREAKFAST.RoomNo, RRESV_BREAKFAST.CheckInDate) in (select HotelID, RoomNo, CheckInDate from ROOM_RESERVATION where ROOM_RESERVATION.InvoiceNo in (select InvoiceNo from RESERVATION where CID=$cid))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();

$count_breakfasts = mysqli_num_rows($result);
for($i=0; $i < $count_breakfasts; $i++){
  $breakfast = mysqli_fetch_row($result);
  array_push($data, $breakfast);
}

$data_json = json_encode($data);
echo $data_json;

?>