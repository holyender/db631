<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php
 // set up database
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/create_db.php";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;
?>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/services.php">Services</a>
</body>
</html>