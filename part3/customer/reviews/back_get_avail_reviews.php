<?php
  // this file is ment to return which room reviews a customer can make given their cid
  // a customer will not be able to make more reviews than the number of times the customer
  // has reserved the room. meaning there's a one to one ratio of room reservations to room reviews
$data_json = file_get_contents('php://input');
// var_dump($data_json);
$data = json_decode($data_json, true);

include('../../config.php');

$cid = (int)$data['cid'];

// figure out how many times a customer has reserved a specific room in a specific hotel
$sql = "select HotelID, RoomNo, COUNT(*) from (ROOM_RESERVATION inner join RESERVATION on ROOM_RESERVATION.InvoiceNo=RESERVATION.InvoiceNo) where CID=$cid group by HotelID, RoomNo order by HotelID, RoomNo";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// collect the data from the number of times a customer reserved a specific room in a specific hotel
$reservations = array();
$count_reservations = mysqli_num_rows($result);
for($i=0; $i < $count_reservations; $i++){
  $room = mysqli_fetch_row($result);
  array_push($reservations, $room);
}
//var_dump($reservations);
// reservations format
// (
// (hotelid, roomno, number of times reserved),
// (hotelid, roomno, number of times reserved),
// ...,
// (hotelid, roomno, number of times reserved)
// )

$data = array();

// figure out the difference between the number of times a customer reserved a specific room in a specific hotel
// and the number of times the customer has reviewed that specific room in that specific hotel
// the customer will be able to review that specific room in that specific hotel for the difference times
for($i=0; $i < count($reservations); $i++){
  $room = $reservations[$i];
  $hotelid = (int)$room[0];
  $roomno = (int)$room[1];
  $count_reserved = (int)$room[2];

  $sql = "select * from ROOM_REVIEW where CID=$cid and HotelID=$hotelid and RoomNo=$roomno";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  // figure out how many times a customer has reviewed a specific room in a specific hotel
  $count_reviews = mysqli_num_rows($result);
  $count_avail = $count_reserved - $count_reviews; // how many times a customer can review that room
  for($j=0; $j < $count_avail; $j++){
    $avail = array();
    array_push($avail, $hotelid, $roomno);
    array_push($data, $avail);
  } // end of for j < count_avail

} // end of for i < reservations

$data_json = json_encode($data);
echo $data_json;

?>