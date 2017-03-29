<?php
  // this file is ment to submit breakfast reviews
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json);
// $data format
// (
// cid, (hotelid, btype, text, rating),
// (hotelid, btype, text, rating), ...,
// (hotelid, btype, text, rating)
// )

include('../../config.php');

$cid = (int)$data[0];

$count_breakfasts = count($data); // remember to exclude the cid
for($i=1; $i < $count_breakfasts; $i++){
  $breakfast = $data[$i];
  $hotelid = (int)$breakfast[0];
  $btype = mysqli_real_escape_string($conn, $breakfast[1]);
  $text = mysqli_real_escape_string($conn, $breakfast[2]);
  $rating = (int)$breakfast[3];

  $sql = "insert into BREAKFAST_REVIEW (HotelID, BType, CID, Text, Rating) values ($hotelid, '$btype', $cid, '$text', $rating)";
  
  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

} // end of for i


?>