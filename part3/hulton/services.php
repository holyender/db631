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
//echo $result;
$data = json_decode($result);

// $data format
// (
// (HotelID, SType, Sprice), (HotelID, SType, Sprice),
// (HotelID, SType, Sprice), (HotelID, SType, Sprice),
// ...,
// (HotelID, SType, Sprice), (HotelID, SType, Sprice)
// )

echo "<table align='center'>";
echo "<caption>Services</caption>";
echo "<thead>";
echo "<tr>";
echo "<th>HotelID</th>";
echo "<th>Type</th>";
echo "<th>Price</th>";
echo "</tr>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "</thead>";
echo "<tbody>";
$count_services = count($data);
for($i=0; $i < $count_services; $i++){
  echo "<tr>";
  $count_fields = count($data[$i]);
  for($j=0; $j < $count_fields; $j++){
    echo "<td>";
    echo $data[$i][$j];
    echo "</td>";
  }
  echo "</tr>";
}
echo "</tbody>";
echo "</table>";

?>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/service.php">Add/Remove a Service</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/homepage.php">Go Back to Homepage</a>
</body>
</html>