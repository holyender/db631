<?php
  // this file is ment to submit a review for a room
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json);

// $data format
// (
// cid,
// (hotelid, roomno, rating, text), (hotelid, roomno, rating, text),
//  ..., (hotelid, roomno, rating, text)
// )

include('../../config.php');

$count_room_reviews = count($data); // remeber to exclude the cid
$cid = $data[0];
for($i=1; $i < $count_room_reviews; $i++){
  $room_review = $data[$i];
  $hotelid = (int)$room_review[0];
  $roomno = (int)$room_review[1];
  $rating = (int)$room_review[2];
  $text = $room_review[3];

  $sql = "insert into ROOM_REVIEW (Rating, Text, CID, HotelID, RoomNo) values ($rating, '$text', $cid, $hotelid, $roomno)";
  
  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

?>