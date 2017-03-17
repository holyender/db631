<?php
$old_hotelid = $_POST['old_hotelid'];
$new_hotelid = $_POST['new_hotelid'];
$old_btype = $_POST['old_btype'];
$new_btype = $_POST['new_btype'];
$old_bprice = $_POST['old_bprice'];
$new_bprice = $_POST['new_bprice'];
$old_description = $_POST['old_description'];
$new_description = $_POST['new_description'];

$data = array("old_hotelid" => $old_hotelid, "new_hotelid" => $new_hotelid, "old_btype" => $old_btype, "new_btype" => $new_btype, "old_bprice" => $old_bprice, "new_bprice" => $new_bprice, "old_description" => $old_description, "new_description" => $new_description);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/back_breakfast.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;

header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/breakfast.php");
?>