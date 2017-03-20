<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$request = $data['info'];

$sql = "";
if(strcmp($request, "breakfasts") == 0){
  $sql = "select distinct BType from BREAKFAST order by BType asc";
}
else if(strcmp($request, "services") == 0){
  $sql = "select distinct SType from SERVICE order by SType asc";
}

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "querry error: " . mysqli_error($conn);
  exit;
}

$data = array();

$count = mysqli_num_rows($result);
for($i=0; $i < $count; $i++){
  $row = mysqli_fetch_row($result);
  $type = $row[0];
  array_push($data, $type);
}

$data_json = json_encode($data);
echo $data_json;

?>