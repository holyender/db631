<?php
  // this file is ment to return the available breakfast reviews
  // a customer can make given their cid. a customer will not be able
  // to review a breakfast more than the amount of times the customer
  // ordered it
$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json, true);

include('../../config.php');

$cid = (int)$data['cid'];

// figure out which breakfasts the customer has ordered
$sql = "select b.HotelID, b.Btype, COUNT(*) as Reserved from ((RRESV_BREAKFAST as b inner join ROOM_RESERVATION as rr on b.HotelID=rr.HotelID and b.RoomNo=rr.RoomNo and b.CheckInDate=rr.CheckInDate) inner join RESERVATION as r on rr.InvoiceNo=r.InvoiceNo) where r.CID=$cid group by b.HotelID, b.Btype order by b.HotelID, b.Btype";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
}

// collect all of the breakfasts that the customer reserved
$breakfasts = array();

$count_breakfasts = mysqli_num_rows($result);
for($i=0; $i < $count_breakfasts; $i++){
  $breakfast = mysqli_fetch_row($result);
  array_push($breakfasts, $breakfast);
}
//var_dump($breakfasts);

// $breakfasts format
// (
// (hotelid, btype, number times reserved),
// (hotelid, btype, number times reserved),
// ....
// (hotelid, btype, number times reserved)
// )

// figure out how many additional times the customer can review
// each breakfast at a specific hotel
$data = array();

$count_breakfasts = count($breakfasts);
for($i=0; $i < $count_breakfasts; $i++){
  $res_breakfast = $breakfasts[$i];
  $res_hotelid = (int)$res_breakfast[0];
  $res_btype = mysqli_real_escape_string($conn, $res_breakfast[1]);
  $res_count = (int)$res_breakfast[2];

  $sql = "select * from BREAKFAST_REVIEW where HotelID=$res_hotelid and Btype='$res_btype' and CID=$cid";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $count_reviews = mysqli_num_rows($result);
  $count_avail = $res_count - $count_reviews;
  for($j=0; $j < $count_avail; $j++){
    $avail = array();
    array_push($avail, $res_hotelid, $res_btype);
    array_push($data, $avail);
  } // end of for j < count_avail
} // end of for i < count_breakfasts

mysqli_close($conn);

$data_json = json_encode($data);
echo $data_json;

?>