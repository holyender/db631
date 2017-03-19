<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json);

include('../../config.php');

$count_res = count($data);
for($i=0; $i < $count_res; $i++){
  $hotelid = (int)$data[$i][0];

  $sql = "select distinct SType from SERVICE where HotelID=$hotelid";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $services = array();

  $count_services = mysqli_num_rows($result);
  for($j=0; $j < $count_services; $j++){
    $row = mysqli_fetch_assoc($result);
    $service = $row['SType'];

    array_push($services, $service);
  } // end of for j

  array_push($data[$i], $services);

} // end of for i

$data_json = json_encode($data);
echo $data_json;

?>