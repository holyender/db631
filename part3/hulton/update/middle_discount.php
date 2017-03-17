<?php
$old_hotelid = $_POST['old_hotelid'];
$new_hotelid = $_POST['new_hotelid'];
$old_roomno = $_POST['old_roomno'];
$new_roomno = $_POST['new_roomno'];
$old_discount = $_POST['old_discount'];
$new_discount = $_POST['new_discount'];
$old_startdate = $_POST['old_startdate'];
$new_startdate = $_POST['new_startdate'];
$old_enddate = $_POST['old_enddate'];
$new_enddate = $_POST['new_enddate'];

$data = array("old_hotelid" => $old_hotelid, "new_hotelid" => $new_hotelid, "old_roomno" => $old_roomno, "new_roomno" => $new_roomno, "old_discount" => $old_discount, "new_discount" => $new_discount, "old_startdate" => $old_startdate, "new_startdate" => $new_startdate, "old_enddate" => $old_enddate, "new_enddate" => $new_enddate);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/back_discount.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;
?>