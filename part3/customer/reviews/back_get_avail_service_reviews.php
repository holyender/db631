<?php
  // this file is ment to return which services
  // a customer can review given their cid
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json, true);

include('../../config.php');

$cid = (int)$data['cid'];

$sql = "select HotelID, Stype from RRESV_SERVICE where (HotelID, RoomNo, CheckInDate) in (select ROOM_RESERVATION.HotelID, ROOM_RESERVATION.RoomNo, ROOM_RESERVATION.CheckInDate from ROOM_RESERVATION where ROOM_RESERVATION.InvoiceNo in (select InvoiceNo from RESERVATION where CID=$cid))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();

$count_services = mysqli_num_rows($result);
for($i=0; $i < $count_services; $i++){
  $service = mysqli_fetch_row($result);
  array_push($data, $service);
}

$data_json = json_encode($data);
echo $data_json;

?>