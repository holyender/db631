<?php
  // this file is ment to determine whether the specific room that
  // the customer is trying to reserve in a specific hotel
  // is available or not
  // to use this file, send it an array consisting of
  // the hotelid, roomno, checkindate, checkoutdate

$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json, true);

// $data format
// (hotelid, roomno, checkindate, checkoutdate)

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$roomno = (int)$data['roomno'];
$our_checkindate = mysqli_real_escape_string($conn, $data['checkindate']);
$our_checkoutdate = mysqli_real_escape_string($conn, $data['checkoutdate']);

if(empty($our_checkindate) or empty($our_checkoutdate)){
  $data = array("response" => "invalid dates");
  $data_json = json_encode($data);
  echo $data_json;
  exit;
}

/* check if the room we specified in the hotel we specified is reserved during the period we want */
$sql = "select * from ROOM_RESERVATION where HotelID=$hotelid and RoomNo=$roomno and ((CheckInDate <= '$our_checkindate' and CheckOutDate >= '$our_checkindate') or (CheckInDate <= '$our_checkoutdate' and CheckOutDate >= '$our_checkoutdate'))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

if(!mysqli_num_rows($result)){
  $data = array("response" => "is available");
  $data_json = json_encode($data);
  echo $data_json;
}
else{
  $data = array("response" => "not available");
  $data_json = json_encode($data);
  echo $data_json;
}

?>