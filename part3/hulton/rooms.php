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
$data = array("info" => "rooms");
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/info/middle_get_info.php";
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
// (rooms), (discounts)
// )
// (rooms) => (HotelID, Floor, RoomNo, Rtype, Capacity, Price), (HotelID, Floor, RoomNo, Rtype, Capacity, Price)
// (discounts) => (HotelID, RoomNo, Discount, StartDate, EndDate), (HotelID, RoomNo, Discount, StartDate, EndDate)

echo "<table align='center'>";
echo "<caption>Rooms</caption>";
echo "<thead>";
echo "<th>HotelID</th>";
echo "<th>Floor</th>";
echo "<th>Room</th>";
echo "<th>Type</th>";
echo "<th>Capacity</th>";
echo "<th>Price</th>";
echo "<tr>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$count_rooms = count($data[0]);
for($i=0; $i < $count_rooms; $i++){
  echo "<tr>";
  $count_fields = count($data[0][$i]);
  for($j=0; $j < $count_fields; $j++){
    echo "<td>";
    echo $data[0][$i][$j];
    echo "</td>";
  }
  echo "<tr>";
}
echo "</tbody>";
echo "</table>";

echo "<br>";

echo "<table align='center'>";
echo "<caption>Discounts</caption>";
echo "<thead>";
echo "<tr>";
echo "<th>HotelID</th>";
echo "<th>Room</th>";
echo "<th>Discount</th>";
echo "<th>Start</th>";
echo "<th>End</th>";
echo "</tr>";
echo "<tr>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "<th><input type='text'></th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$count_discounts = count($data[1]);
for($i=0; $i < $count_discounts; $i++){
  echo "<tr>";

  $count_fields = count($data[1][$i]);
  for($j=0; $j < $count_fields; $j++){
    echo "<td>";
    echo $data[1][$i][$j];
    echo "</td>";
  }

  echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>
<br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/room.php">Add/Remove a Room</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/room.php">Update a Room</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/discount.php">Add/Remove a Discount</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/update/discount.php">Update a Discount</a>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/homepage.php">Go Back to Homepage</a>
</body>
</html>