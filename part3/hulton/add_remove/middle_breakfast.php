<?php
$hotelid = $_POST['hotelid'];
$btype = $_POST['btype'];
$bprice = $_POST['bprice'];
$description = $_POST['description'];
$request = $_POST['request'];

$data = array("hotelid" => $hotelid, "btype" => $btype, "bprice" => $bprice, "description" => $description, "request" => $request);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/back_breakfast.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;

header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/breakfast.php");

?>