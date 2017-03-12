<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

$request = $data['info'];

include('../../config.php');

$data = array();

if(strcmp($request, "services") == 0){
  $sql = "select HotelID, SType, SPrice from SERVICE";

  $service_result = mysqli_query($conn, $sql);
  if(!$service_result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $count_services = mysqli_num_rows($service_result);

  for($i=0; $i < $count_services; $i++){
    $service = mysqli_fetch_row($service_result);

    array_push($data, $service);
  }
}
else if(strcmp($request, "hotels") == 0){
  $sql = "select distinct HotelID from HOTEL";

  $hotel_result = mysqli_query($conn, $sql);
  if(!$hotel_result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $count_hotels = mysqli_num_rows($hotel_result);
  for($j=0; $j < $count_hotels; $j++){
    $hotel = mysqli_fetch_assoc($hotel_result);
    array_push($data, $hotel['HotelID']);
  }
}

$data_json = json_encode($data);
echo $data_json;

?>