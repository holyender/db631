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

// check if we are already logged in
session_start();
if(isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/customer/homepage.php");
}
?>
<form method="post" action="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/middle_login.php" autocomplete="off">
<input type="text" name="email" id="email" placeholder="EMAIL" required>
<br>
<input type="password" name="cid" id="cid" placeholder="CID" required>
<br>
<input type="submit" value="Login">
<span>
<?php
    if(isset($_GET['login_fail'])){
    echo "Invalid Email or CID";
  }
  ?>
</span>
</form>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/registration/registration.php">Register</a>
</body>
</html>