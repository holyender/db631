<!DOCTYPE HTML>
<html>
<style>
table, th, td{
 border: 1px solid black;
 border-collapse: collapse;
 padding: 5px;
}
</style>
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

echo "<table>";
echo "<caption>Breakfasts</caption>";
echo "<thead>";
echo "<tr>";
echo "<th>HotelID</th>";
echo "<th>Type</th>";
echo "<th>Price</th>";
echo "<th>Description</th>";
echo "</tr>";
echo "<tr>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th></th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
// insert data
echo "</tbody>";
echo "</table>";

?>
<br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/breakfast.php">Add/Remove Breakfast</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/homepage.php">Go Back to Homepage</a>
</body>
</html>