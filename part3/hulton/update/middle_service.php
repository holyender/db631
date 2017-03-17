<?php
$old_hotelid = $_POST['old_hotelid'];
$new_hotelid = $_POST['new_hotelid'];
$old_stype = $_POST['old_stype'];
$new_stype = $_POST['new_stype'];
$old_sprice = $_POST['old_sprice'];
$new_sprice = $_POST['new_sprice'];

$data = array("old_hotelid" => $old_hotelid, "new_hotelid" => $new_hotelid, "old_stype" => $old_stype, "new_stype" => $new_stype, "old_sprice" => $old_sprice, "new_sprice" => $new_sprice);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/back_service.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;

header('Location: http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/service.php');
?>