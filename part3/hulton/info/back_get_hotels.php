<?php
include("../../config.php");

$sql = "select HotelID from HOTEL";

$result = mysqli_query($conn, $sql);

$data = array();
$count_hotels = mysqli_num_rows($result);
for($i=0; $i < $count_hotels; $i++){
  $row = mysqli_fetch_assoc($result);
  array_push($data, $row['HotelID']);
}

$data_json = json_encode($data);
echo $data_json;
?>