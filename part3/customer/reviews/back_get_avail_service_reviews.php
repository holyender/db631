<?php
  // this file is ment to return which services
  // a customer can review given their cid
  // a customer will not be able to make more reviews than
  // the number of times the customer has orderred the service
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json, true);

include('../../config.php');

$cid = (int)$data['cid'];

// figure out which services the customer has ordered
$sql = "select s.HotelID, s.Stype, COUNT(*) as Reserved from ((RRESV_SERVICE as s inner join ROOM_RESERVATION as room_res on s.HotelID=room_res.HotelID and s.RoomNo=room_res.RoomNo and s.CheckInDate=room_res.CheckInDate) inner join RESERVATION as r on room_res.InvoiceNo=r.InvoiceNo) where r.CID=$cid group by s.HotelID, s.Stype order by s.HotelID, s.Stype";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// collect all of the services that the customer has reserved
$services = array();
$count_services = mysqli_num_rows($result);
for($i=0; $i < $count_services; $i++){
  $service = mysqli_fetch_row($result);
  array_push($services, $service);
}
//var_dump($services);
// $services format
// (
// (hotelid, stype, number of times reserved),
// (hotelid, stype, number of times reserved),
// ...,
// (hotelid, stype, number of times reserved),
// )

// figure out how many additional times the customer can review the service at a specific hotel
$data = array();

$count_services = count($services);
for($i=0; $i < $count_services; $i++){
  $service = $services[$i];
  $res_hotelid = (int)$service[0];
  $res_stype = mysqli_real_escape_string($conn, $service[1]);
  $count_res = (int)$service[2];

  $sql = "select * from SERVICE_REVIEW where HotelID=$res_hotelid and SType='$res_stype' and CID=$cid";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
    
  $count_rev = mysqli_num_rows($result);
  $count_avail = $count_res - $count_rev;
  for($j=0; $j < $count_avail; $j++){
    $avail = array();
    array_push($avail, $res_hotelid, $res_stype);
    array_push($data, $avail);
  } // end of j < $count_avail

} // end for i < count_services

mysqli_close($conn);

$data_json = json_encode($data);
echo $data_json;

?>