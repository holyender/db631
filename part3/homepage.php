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
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/login/index.php");
}

// if we are logged ing properly
// then welcome us
echo "Hello " . $_SESSION['name'];
?>
<table>
<caption></caption>
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

$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/reservation/middle_get_reservations.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
echo $result;
?>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/login/logout.php">Logout</a>
</body>
</html>