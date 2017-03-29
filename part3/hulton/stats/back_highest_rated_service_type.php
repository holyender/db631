<?php
include('../../config.php');

$sql = "";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();

$count_services = mysqli_num_rows($result);
for($i=0; $i < $count_services; $i++){
  $row = mysqli_fetch_row($result);
  array_push($data, $row);
}

$data_json = json_encode($data);
echo $data_json;
?>