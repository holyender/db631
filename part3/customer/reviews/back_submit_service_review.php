<?php
  // file file is ment to submit service reviews a customer wants to make
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json);

include('../../config.php');

$cid = (int)$data[0];

$count_services = count($data); // remember to exclude the cid
for($i=1; $i < $count_services; $i++){
  $service_review = $data[$i];
  $hotelid = (int)$service_review[0];
  $stype = mysqli_real_escape_string($conn, $service_review[1]);
  $rating = (int)$service_review[2];
  $text = mysqli_real_escape_string($conn, $service_review[3]);

  $sql = "insert into SERVICE_REVIEW (HotelID, SType, CID, Rating, Text) values ($hotelid, '$stype', $cid, $rating, '$text')";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
} // end of for i

?>