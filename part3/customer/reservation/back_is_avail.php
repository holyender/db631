<?php
  // this file is ment to determine whether
  // reserving a room in a hotel is available or not
  // to use this file, send it an array consisting of
  // the hotelid, roomno, checkindate, checkoutdate

$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

// $data format
// (hotelid, roomno, checkindate, checkoutdate)

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$roomno = (int)$data['roomno'];
$our_checkindate = $data['checkindate'];
$our_checkoutdate = $data['checkoutdate'];

if(empty($our_checkindate) or empty($our_checkoutdate)){
  $data = array("response" => "invalid dates");
  $data_json = json_encode($data);
  echo $data_json;
  exit;
}

$sql = "select CheckInDate, CheckOutDate from ROOM_RESERVATION where HotelID=$hotelid and RoomNo=$roomno";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$avail = true;

$count_resv = mysqli_num_rows($result);
for($i=0; $i < $count_resv; $i++){
  $row = mysqli_fetch_assoc($result);
  $checkindate = $row['CheckInDate'];
  $checkoutdate = $row['CheckOutDate'];

  if( ($our_checkindate >= $checkindate and $our_checkindate <= $checkoutdate) or ($our_checkoutdate >= $checkindate and $our_checkoutdate <= $checkoutdate) ){
    $avail = false;
  }

}

$data = array("avail" => $avail);
$data_json = json_encode($data);
echo $data_json;

?>