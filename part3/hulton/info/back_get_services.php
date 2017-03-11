<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$sql = "select distinct HotelID from HOTEL";

$hotel_result = mysqli_query($conn, $sql);
if(!$hotel_result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();
$count_hotels = mysqli_num_rows($hotel_result);
//var_dump($count_hotels);

for($i=0; $i < $count_hotels; $i++){
  $hotelid_services = array();

  $row = mysqli_fetch_assoc($hotel_result);
  $hotelid = (int)$row['HotelID'];

  array_push($hotelid_services, $hotelid);

  $sql = "select SType, SPrice from SERVICE where HotelID=$hotelid";

  $services_result = mysqli_query($conn, $sql);
  if(!$services_result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $count_services = mysqli_num_rows($services_result);
  for($j=0; $j < $count_services; $j++){
    $service = mysqli_fetch_row($services_result);
    array_push($hotelid_services, $service);
  } // end of for loop $j

  array_push($data, $hotelid_services);
} // end of for loop $i
var_dump($data);
// $data format
// (
// (HotelID, SType, SPrice, SType, SPrice, ..., SType, SPrice), 
// (HotelID, SType, SPrice, SType, SPrice, ..., SType, SPrice), 
// ...
// (HotelID, SType, SPrice, SType, SPrice, ..., SType, SPrice), 
// )

?>