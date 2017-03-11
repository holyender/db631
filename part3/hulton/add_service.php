<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php
$data = array("info" => "services");
$data_json = json_encode($data);

$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/info/middle_get_info.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;
?>
</body>
</html>