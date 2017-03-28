<!DOCTYPE HTML>
<html>
<head>
<style>
table, th, td{
 border: 1px solid black;
 border-collapse: collapse;
 padding: 5px;
}
</style>
</head>
<body>
<?php
  // check if we are properly logged in
  // if not then send us to the login screen
session_start();
if(!isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/index.php");
}

// if we are logged ing properly
// then welcome us
echo "Hello " . $_SESSION['name'];
?>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/info/update_info.php">Update Information</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/make_reservation.php">Make Reservation</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reviews/review.php">Make a Review</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/logout.php">Logout</a>
</body>
</html>