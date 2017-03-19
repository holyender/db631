<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);
//var_dump($data);

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$rtype = mysqli_real_escape_string($conn, $data['rtype']);
$checkindate = $data['checkindate'];

$sql = "select HotelID, RoomNo, Price, Capacity from ROOM where HotelID=$hotelid and Rtype like '%$rtype%'";

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

// $data format
// (
// (hotelid, roomno, price, capacity),
// (hotelid, roomno, price, capacity),
// ...,
// (hotelid, roomno, price, capacity),
// ) 

// figure out which rooms have discounts
for($i=0; $i < $count_rooms; $i++){
  $hotelid = (int)$data[$i][0];
  $roomno = (int)$data[$i][1];

  $sql = "select Discount from DISCOUNTED_ROOM where HotelID=$hotelid and RoomNo=$roomno and StartDate <= '$checkindate' and EndDate >= '$checkindate'";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $row = mysqli_fetch_assoc($result);
  $discount = $row['Discount'];

  array_push($data[$i], $discount);
}

$data_json = json_encode($data);
echo $data_json;

?>