<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

$request = $data['info'];

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
  $hotelid_info = array();
  
  $row = mysqli_fetch_assoc($hotel_result);
  $hotelid = (int)$row['HotelID'];

  array_push($hotelid_info, $hotelid);

  if(strcmp($request, "services") == 0){

    $sql = "select SType, SPrice from SERVICE where HotelID=$hotelid";

    $services_result = mysqli_query($conn, $sql);
    if(!$services_result){
      echo "query error: " . mysqli_error($conn);
      exit;
    }
    
    $count_services = mysqli_num_rows($services_result);
    
    for($j=0; $j < $count_services; $j++){
      $service = mysqli_fetch_row($services_result);
      array_push($hotelid_info, $service);
    } // end of for loop $j

  } // end of services
  else if(strcmp($request, "breakfasts") == 0){

    $sql = "select BType, BPrice, Description from BREAKFAST where HotelID=$hotelid";

    $breakfasts_result = mysqli_query($conn, $sql);
    if(!$breakfasts_result){
      echo "query error: " . mysqli_error($conn);
      exit;
    }

    $count_breakfasts = mysqli_num_rows($breakfast_results);

    for($j=0; $j < $count_breakfasts; $j++){
      $breakfast = mysqli_fetch_row($breakfasts_result);
      array_push($hotelid_info, $breakfast);
    } // end of for loop $j

  } // end of breakfasts

  array_push($data, $hotelid_info);

} // end of for loop $i

// $data format
// (
// (HotelID, (SType, SPrice), (SType, SPrice), (...), (SType, SPrice)), 
// (HotelID, (SType, SPrice), (SType, SPrice), (...), (SType, SPrice)), 
// ...
// (HotelID, (SType, SPrice), (SType, SPrice), (...), (SType, SPrice)), 
// )

$data_json = json_encode($data);
echo $data_json;

?>