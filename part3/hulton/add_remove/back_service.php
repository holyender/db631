<?php
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json, true);

$hotelid = (int)$data['hotelid'];
$stype = $data['stype'];
$sprice = $data['sprice'];
$request = $data['request'];

include('../../config.php');

if(strcmp($request, "add") == 0){
  $sql = "insert into SERVICE (HotelID, SType, SPrice) values ($hotelid, '$stype', $sprice)";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}
else if(strcmp($request, "remove") == 0){
  $sql = "delete from SERVICE where HotelID=$hotelid and SType='$stype'";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

?>