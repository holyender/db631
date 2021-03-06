<?php
  // back_get_info.php
  // returns an array of distinct breakfasts or services
  // for every hotel, meaning this file will return
  // every type of distinct breakfasts and services
  // that every hotels has. to use this file send it an
  // associative array with the info you want
  // e.g. ("info" => "breakfasts")

$data_json = file_get_contents('php://input');
// var_dump($data_json);
$data = json_decode($data_json, true);

$request = $data['info'];

include('../../config.php');

// we requested for all of the distinct breakfast types
if(strcmp($request, "breakfasts") == 0){
  $sql = "select distinct BType from BREAKFAST order by BType asc";

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
// we requested for all of the distinct service types
else if(strcmp($request, "services") == 0){
  $sql = "select distinct SType from SERVICE order by SType asc";

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