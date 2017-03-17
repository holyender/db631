<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$btype = mysqli_real_escape_string($conn, $data['btype']);
$bprice = (float)$data['bprice'];
$description = $data['description'];

$request = $data['request'];

if(strcmp($request, "add") == 0){
  $sql = "insert into BREAKFAST (HotelID, BType, BPrice, Description) values ($hotelid, '$btype', $bprice, '$description')";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}

else if(strcmp($request, "remove") == 0){
  $sql = "delete from BREAKFAST where HotelID=$hotelid and BType='$btype'";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}


?>