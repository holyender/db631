<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

// data array format
// ((hotelid, roomno), (hotelid, roomno), ..., (hotelid, roomno))
// an array of arrays consisting of each hotel id and room no

include('../../config.php');

// for each reservation
// check whether it has breakfast
$count_res = count($data);
for($i=0; $i < $count_res; $i++){
  $hotelid = (int)$data[$i][0];
  
  $sql = "select distinct BType from BREAKFAST where HotelID=$hotelid";
  
  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $breakfasts = array();

  $count_breakfasts = mysqli_num_rows($result);
  for($j=0; $j < $count_breakfasts; $j++){
    $row = mysqli_fetch_assoc($result);
    $breakfast = $row['BType'];

    array_push($breakfasts, $breakfast);
  } // end of for j

  array_push($data[$i], $breakfasts);

} // end of for i

$data_json = json_encode($data);
echo $data_json;

?>