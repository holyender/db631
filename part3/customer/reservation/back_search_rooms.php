<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json, true);
//var_dump($data);

include('../../config.php');

$hotelid = (int)$data['hotelid'];
$rtype = mysqli_real_escape_string($conn, $data['rtype']);
$checkindate = mysql_real_escape_string($conn, $data['checkindate']);

$sql = "select HotelID, RoomNo, Price, Capacity from ROOM where HotelID=$hotelid and Rtype like '%$rtype%'";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$data = array();

$count_rooms = mysqli_num_rows($result);

for($i=0; $i < $count_rooms; $i++){
  $room = mysqli_fetch_row($result);
  array_push($data, $room);
}

$data_json = json_encode($data);
echo $data_json;

?>