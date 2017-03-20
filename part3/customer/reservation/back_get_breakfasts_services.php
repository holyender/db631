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
$data = json_decode($data_json, true);

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$roomno = (int)$data['roomno'];
$checkindate = $data['checkindate'];

// get the room information
$sql = "select Rtype, Price, Capacity from ROOM where HotelID=$hotelid and RoomNo=$roomno";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$row = mysqli_fetch_assoc($result);
array_push($data, $row['Rtype']);
array_push($data, $row['Price']);
array_push($data, $row['Capacity']);

// find the discount information
$sql = "select Discount from DISCOUNTED_ROOM where HotelID=$hotelid and RoomNo=$roomno and StartDate <= '$checkindate' and EndDate >= '$checkindate'";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$row = mysqli_fetch_assoc($result);
$discount = $row['Discount'];
array_push($data, $discount);

$request = array("info" => "breakfasts");
$request_json = json_encode($request);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/info/back_get_breakfasts_services.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$breakfasts_json = curl_exec($ch);

curl_close($ch);

$data_breakfasts = array();

$breakfasts = json_decode($breakfasts_json);
$count_breakfasts = count($breakfasts);

// find the price for each breakfast for a room in a hotel
// if the hotel doesn't have that kind of breakfast, the price will be null
for($i=0; $i < $count_breakfasts; $i++){
  $btype = $breakfasts[$i];
  array_push($data_breakfasts, $btype);

  $sql = "select BPrice from BREAKFAST where HotelID=$hotelid and BType='$btype'";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $row = mysqli_fetch_row($result);
  $price = $row[0];
  array_push($data_breakfasts, $price);
  
}
array_push($data, $data_breakfasts);

// find all of the services
$request = array("info" => "services");
$request_json = json_encode($request);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/info/back_get_breakfasts_services.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$services_json = curl_exec($ch);

curl_close($ch);

$services = json_decode($services_json);
$data_services = array();

// find the price for each service for a room in a hotel
// if the hotel doesn't have that kind of service, the price will be null
$count_services = count($services);
for($i=0; $i < $count_services; $i++){
  $stype = $services[$i];
  array_push($data_services, $stype);

  $sql = "select SPrice from SERVICE where HotelID=$hotelid and SType='$stype'";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }  

  $row = mysqli_fetch_row($result);
  $price = $row[0];
  array_push($data_services, $price);
}

array_push($data, $data_services);

$data_json = json_encode($data);
echo $data_json;

?>