<?php
$hotelid = $_POST['hotelid'];
$roomno = $_POST['roomno'];
$rtype = $_POST['rtype'];
$price = $_POST['price'];
$description = $_POST['description'];
$floor = $_POST['floor'];
$capacity = $_POST['capacity'];
$request = $_POST['request'];

$data = array("hotelid" => $hotelid, "roomno" => $roomno, "rtype" => $rtype, "price" => $price, "description" => $description, "floor" => $floor, "capactiry" => $capacity, "request" => $request);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/back_room.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;

header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/room.php");
?>