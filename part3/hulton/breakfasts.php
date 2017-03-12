<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php
$data = array("info" => "breakfasts");
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/info/middle_get_info.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;

?>
<br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/breakfast.php">Add/Remove Breakfast</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/homepage.php">Go Back to Homepage</a>
</body>
</html>