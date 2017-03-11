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

$data = json_decode($result);
//var_dump($data);
// $data format
// (
// (HotelID, ((SType, SPrice), (SType, SPrice), (...), (SType, SPrice)), 
// (HotelID, ((SType, SPrice), (SType, SPrice), (...), (SType, SPrice)), 
// ...
// (HotelID, ((SType, SPrice), (SType, SPrice), (...), (SType, SPrice)), 
// )

$count_hotels = count($data);
for($i=0; $i < $count_hotels; $i++){
  $hotelid = $data[$i][0];
  echo "<table align='center'>";
  echo "<caption>HotelID: $hotelid</caption>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>Type</th>";
  echo "<th>Price</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  $count_services = count($data[$i]) - 1;
  for($j=1; $j <= $count_services; $j++){
    echo "<tr>";
    $stype = $data[$i][$j][0];
    $sprice = $data[$i][$j][1];
    echo "<td>" . $stype . "</td>";
    echo "<td>" . $sprice . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
  echo "<br><br>";
}
?>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add/add_service.php">Add a Service</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/homepage.php">Go Back to Homepage</a>
</body>
</html>