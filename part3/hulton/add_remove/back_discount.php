<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

$hotelid = (int)$data['hotelid'];
$roomno = (int)$data['roomno'];
$discount = (float)$data['discount'];
$startdate = $data['startdate'];
$enddate = $data['enddate'];

$request = $data['request'];

include('../../config.php');

if(strcmp($request, "add") == 0){

  $sql = "insert into DISCOUNTED_ROOM (HotelID, RoomNo, Discount, StartDate, EndDate) values ($hotelid, $roomno, $discount, '$startdate', '$enddate')";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

else if(strcmp($request, "remove") == 0){
  $sql = "delete from DISCOUNTED_ROOM where HotelID=$hotelid and RoomNo=$roomno";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

?>