<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php
$data = array("info" => "hotels");
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/info/middle_get_info.php";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$data = json_decode($result);

// $data format
// (hotelid, hotelid, ..., hotelid)
?>
<form method="post" action="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/middle_service.php">
<select name="hotelid">
<?php
$count_hotels = count($data);
for($i=0; $i < $count_hotels; $i++){
  echo "<option value='" . $data[$i] .  "'>" . $data[$i] . "</option>";
}
?>
</select>
<br>
<input type="text" name="stype" placeholder="Type" required>
<br>
<input type="text" name="sprice" placeholder="Price">
<br>
<select name="request">
<option value="add">Add</option>
<option value="remove">Remove</option>
</select>
<br><br>
<input type="submit" value="Submit">
</form>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/services.php">Go Back to Services</a>
</body>
</html>