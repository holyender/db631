<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$roomno = (int)$data['roomno'];
$rtype = mysqli_real_escape_string($conn, $data['rtype']);
$price = (float)$data['price'];
$description = mysqli_real_escape_string($conn, $data['description']);
$floor = (int)$data['floor'];
$capacity = (int)$data['capacity'];

$request = $data['request'];

if(strcmp($request, "add") == 0){
  $sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values ($hotelid, $roomno, '$rtype', $price, '$description', $floor, $capacity)";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
}
else if(strcmp($request, "remove") == 0){
  $sql = "delete from ROOM where HotelID=$hotelid and RoomNo=$roomno";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . msqli_error($conn);
    exit;
  }
}

?>