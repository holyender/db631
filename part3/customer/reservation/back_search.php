<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$country = mysqli_real_escape_string($conn, $data['country']);
$state = mysqli_real_escape_string($conn, $data['state']);
$zip = mysqli_real_escape_string($conn, $data['zip']);

$sql = "select HotelID, Street, Country, State, Zip from HOTEL";

if(!empty($country) or !empty($state) or !empty($zip)){
  $sql = $sql . " where";
}

if(!empty($country)){
  $sql = $sql . " Country like '%$country%'";
}

if(!empty($state) and !empty($country)){
  $sql = $sql . " and";
}

if(!empty($state)){
  $sql = $sql . " State like '%$state%'";
}

if(!empty($zip) and !empty($state)){
  $sql = $sql . " and";
}

if(!empty($zip)){
  $sql = $sql . " Zip like '%$zip%'";
}

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();

$count_hotels = mysqli_num_rows($result);
for($i=0; $i < $count_hotels; $i++){
  $hotel = mysqli_fetch_row($result);
  array_push($data, $hotel);
}

$data_json = json_encode($data);
echo $data_json;

?>