<?php
  // this file is ment to find out 
  // the room information for the given room no in a specific hotel
  // which breakfasts and services are available for a certain hotel
  // this file will return the original array
  // while appending the additional room information and
  // two additional arrays
  // the first consisting of the breakfasts for the hotel with its prices
  // the second consisiting of the services for the hotel with its prices

$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json, true);

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$roomno = (int)$data['roomno'];
$checkindate = mysqli_real_escape_string($conn, $data['checkindate']);
$checkoutdate = mysqli_real_escape_string($conn, $data['checkoutdate']);

// get the room information 
$sql = "select Rtype, Price, Capacity from ROOM where HotelID=$hotelid and RoomNo=$roomno";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();

array_push($data, $checkindate, $checkoutdate, $hotelid, $roomno);

$room = mysqli_fetch_row($result);
for($i=0; $i < count($room); $i++){
  array_push($data, $room[$i]);
}

// get the discount for the room
$sql = "select Discount from DISCOUNTED_ROOM where HotelID=$hotelid and RoomNo=$roomno and StartDate <= '$checkindate' and EndDate >= '$checkindate'";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$discount = mysqli_fetch_row($result);
array_push($data, $discount[0]);

// find out which breakfasts are offered at that hotel
// and how much each costs

$sql = "select distinct BType from BREAKFAST order by BType asc";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$breakfasts = array();

$count_breakfasts = mysqli_num_rows($result);
for($i=0; $i < $count_breakfasts; $i++){
  $breakfast = array();

  $row = mysqli_fetch_row($result);
  $btype = mysqli_real_escape_string($conn, $row[0]);

  $sql = "select BPrice from BREAKFAST where HotelID=$hotelid and BType='$btype'";

  $breakfast_result = mysqli_query($conn, $sql);
  if(!$breakfast_result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $breakfast_row = mysqli_fetch_row($breakfast_result);
  $bprice = $breakfast_row[0];
  
  array_push($breakfast, $btype, $bprice);
  array_push($breakfasts, $breakfast);

}

array_push($data, $breakfasts);

// figure out which services are offered at that hotel
// and how much each costs
$sql = "select distinct SType from SERVICE order by SType asc";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$services = array();

$count_services = mysqli_num_rows($result);
for($i=0; $i < $count_services; $i++){
  $service = array();

  $row = mysqli_fetch_row($result);
  $stype = mysqli_real_escape_string($conn, $row[0]);

  $sql = "select SPrice from SERVICE where SType='$stype' and HotelID=$hotelid";

  $service_result = mysqli_query($conn, $sql);
  if(!$service_result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $service_row = mysqli_fetch_row($service_result);
  $sprice = $service_row[0];

  array_push($service, $stype, $sprice);
  array_push($services, $service);
}

array_push($data, $services);

// $data format
// ( hotelid, roomno, checkindate, checkoutdate,
// rtype, price, capacity, discount, (breakfasts), (services)
// )

$data_json = json_encode($data);
echo $data_json;

mysqli_close($conn)

?>