<?php
$old_hotelid = $_POST['old_hotelid'];
$new_hotelid = $_POST['new_hotelid'];
$old_roomno = $_POST['old_roomno'];
$new_roomno = $_POST['new_roomno'];
$old_rtype = $_POST['old_rtype'];
$new_rtype = $_POST['new_rtype'];
$old_price = $_POST['old_price'];
$new_price = $_POST['new_price'];
$old_description = $_POST['old_description'];
$new_description = $_POST['new_description'];
$old_floor = $_POST['old_floor'];
$new_floor = $_POST['new_floor'];
$old_capacity = $_POST['old_capacity'];
$new_capacity = $_POST['new_capacity'];

$data = array("old_hotelid" => $old_hotelid, "new_hotelid" => $new_hotelid, "old_roomno" => $old_roomno, "new_roomno" => $new_roomno, "old_rtype" => $old_rtype, "new_rtype" => $new_rtype, "old_price" => $old_price, "new_price" => $new_price, "old_description" => $old_description, "new_description" => $new_description, "old_floor" => $old_floor, "new_floor" => $new_floor, "old_capacity" => $old_capacity, "new_capacity" => $new_capacity);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/back_room.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;

header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/room.php");
?>