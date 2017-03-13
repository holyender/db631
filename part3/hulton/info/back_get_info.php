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
else if(strcmp($request, "rooms") == 0){
  // push the rooms
  $sql = "select HotelID, Floor, RoomNo, Rtype, Capacity, Price from ROOM";

  $rooms_result = mysqli_query($conn, $sql);
  if(!$rooms_result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $rooms = array();

  $count_rooms = mysqli_num_rows($rooms_result);
  for($i=0; $i < $count_rooms; $i++){
    $room = mysqli_fetch_row($rooms_result);
    array_push($rooms, $room);
  }

  array_push($data, $rooms);

  // push the discounts
  $sql = "select HotelID, RoomNo, Discount, StartDate, EndDate from DISCOUNTED_ROOM";

  $discounts_result = mysqli_query($conn, $sql);
  if(!$discounts_result){
    echo "query error: " . mysqli_error($conn);;
    exit;
  }

  $discounts = array();

  $count_discounts = mysqli_num_rows($discounts_result);
  for($i=0; $i < $count_discounts; $i++){
    $discount = mysqli_fetch_row($discounts_result);
    array_push($discounts, $discount);
  }

  array_push($data, $discounts);
}

$data_json = json_encode($data);
echo $data_json;

?>