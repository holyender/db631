<?php
$data_json = file_get_contents('php://input');
$data = json_decode($data_json);

// data array format
// ((hotelid, roomno), (hotelid, roomno), ..., (hotelid, roomno))
// an array of arrays consisting of each hotel id and room no

include('../../config.php');

$count_res = count($data);
for($i=0; $i < $count_res; $i++){
  $hotelid = (int)$data[$i][0];
  $roomno = (int)$data[$i][1];

  $sql = "select Rtype, Price from ROOM where HotelID=$hotelid and RoomNo=$roomno";
  
  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $count_rooms = mysqli_num_rows($result);
  for($i=0; $i < $count_rooms; $i++){
    $row = mysqli_fetch_assoc($result);

    $rtype = $row['Rtype'];
    $price = $row['Price'];

    
  }
}

?>