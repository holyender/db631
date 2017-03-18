<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

$request = $data['info'];

include('../../config.php');

if(strcmp($request, "breakfasts") == 0){
  $sql = "select distinct BType from BREAKFAST";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $data = array();

  $count_breakfasts = mysqli_num_rows($result);
  for($i=0; $i < $count_breakfasts; $i++){
    $breakfast = mysqli_fetch_row($result);
    array_push($data, $breakfast[0]);
  }

  $data_json = json_encode($data);
  echo $data_json;
}
else if(strcmp($request, "services") == 0){
  $sql = "select distinct SType from SERVICE";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $data = array();

  $count_services = mysqli_num_rows($result);
  for($i=0; $i < $count_services; $i++){
    $service = mysqli_fetch_row($result);
    array_push($data, $service[0]);
  }

  $data_json = json_encode($data);
  echo $data_json;
}
?>