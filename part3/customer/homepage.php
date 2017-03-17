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
<table>
<caption>Upcoming Reservations</caption>
<thead>
<tr>
<th>Hotel ID</th>
<th>Floor</th>
<th>Room No</th>
<th>Room Type</th>
<th>Check In Date</th>
<th>Check Out Date</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<?php
$data = array("cid" => $_SESSION['cid']);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_get_reservations.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;
?>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/info/update_info.php">Update Information</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/make_reservation.php">Make Reservation</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/logout.php">Logout</a>
</body>
</html>