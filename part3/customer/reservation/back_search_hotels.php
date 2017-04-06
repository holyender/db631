<?php
  // this file will return information about a hotel
  // that a customer is searching for given a country and state
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$country = mysqli_real_escape_string($conn, $data['country']);
$state = mysqli_real_escape_string($conn, $data['state']);

// set up the initial query without knowing if the customer
// gave a state or country
$sql = "select HotelID, Street, Country, State, Zip from HOTEL";

// if the customer did provide some information
// then we have to add a condition statement to our query
if(!empty($country) or !empty($state)){
  $sql = $sql . " where";
}

// check if the customer provided a country
if(!empty($country)){
  $sql = $sql . " Country like '%$country%'";
}

// check if the customer gave both a country and a state
if(!empty($state) and !empty($country)){
  $sql = $sql . " and";
}

// check if the customer provided a state
if(!empty($state)){
  $sql = $sql . " State like '%$state%'";
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