<?php

include('../../config.php');

$sql = "";

$result = mysqli_query($conn, $sql);

$data = array();

$count_customers = mysqli_num_rows($result);
for($i=0; $i < $count_customers; $i++){
  $row = mysqli_fetch_row($result);
  array_push($data, $row);
}

$data_json = json_encode($data);
echo $data_json;

?>