<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php
$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/create_db.php";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;
?>
<form method="post" action="http://afsaccess1.njit.edu/~jjl37/database/part3/login/middle_login.php" autocomplete="off">
<input type="text" name="cid" id="cid" placeholder="CID">
<input type="submit" value="Login">
</form>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/registration/registration.php">Register</a>
</body>
</html>