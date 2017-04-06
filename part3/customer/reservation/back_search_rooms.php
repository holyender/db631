<?php
  // this file should return the rooms that are available
  // given a hotel id, room type, and a check in date
  // only rooms that aren't already checked out should be returned
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);
//var_dump($data);

// $data format
// (hotelid, rtype, checkindate)

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$rtype = mysqli_real_escape_string($conn, $data['rtype']);
$checkindate = mysqli_real_escape_string($conn, $data['checkindate']);

// get all of the rooms that are not already reserved in a specific hotel with a given room type
$sql = "select r1.HotelID, r1.RoomNo, r1.Rtype, r1.Price, r1.Capacity, d1.Discount from (ROOM as r1 left outer join DISCOUNTED_ROOM as d1 on r1.HotelID=d1.HotelID and r1.RoomNo=d1.RoomNo) where r1.HotelID=$hotelid and r1.Rtype like '%$rtype%' and (r1.HotelID, r1.RoomNo) not in (select rr2.HotelID, rr2.RoomNo from ROOM_RESERVATION as rr2 where rr2.HotelID=$hotelid and rr2.CheckInDate <= '$checkindate' and rr2.CheckOutDate >= '$checkindate')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$rooms_avail = array();

$count_rooms_avail = mysqli_num_rows($result);
for($i=0; $i < $count_rooms_avail; $i++){
  $room = mysqli_fetch_row($result);
  array_push($rooms_avail, $room);
}

//var_dump($rooms_avail);
/*
  $rooms_avail format
  (hotelid, roomno, rtype, price, capacity, discount),
  (hotelid, roomno, rtype, price, capacity, discount),
  ...,
  (hotelid, roomno, rtype, price, capacity, discount)
*/

$data = array();

/* now that we have gotten all of the possible rooms available, let's double check the discounts available per room */
$count_rooms_avail = count($rooms_avail);
for($i=0; $i < $count_rooms_avail; $i++){
  $room = $rooms_avail[$i];
  $hotelid = (int)$room[0];
  $roomno = (int)$room[1];
  $rtype = $room[2];
  $price = (float)$room[3];
  $capacity = $room[4];
  $discount = (float)$room[5];

  /* get the for the specific room in the specific hotel where its discount date period is between our check in date
   if none is returned, then change the discount to null */
  $sql = "select Discount from DISCOUNTED_ROOM where HotelID=$hotelid and RoomNo=$roomno and StartDate <= '$checkindate' and EndDate >= '$checkindate'";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  if(!mysqli_num_rows($result)){
    $discount = 0.0000;
  }
  
  /* collect all of the information for all of the rooms now */
  $row = array();
  array_push($row, $hotelid, $roomno, $rtype, $price, $capacity, $discount);
  array_push($data, $row);  
  
}

$data_json = json_encode($data);
echo $data_json;

?>