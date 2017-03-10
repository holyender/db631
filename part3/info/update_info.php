<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php
session_start();
if(!isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/login/index.php");
}

$data = array("cid" => $_SESSION['cid']);
$data_json = json_encode($data);

$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/info/middle_get_info.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

$data = json_decode($result, true);

echo "<form autocomplete='off'>";
echo "Name: " . $data["Name"];
echo "<input type='text' name='name' id='name'><br>";
echo "Address: " . $data["Address"];
echo "<input type='text' name='address' id='address'><br>";
echo "Phone No: " . $data["Phone_no"];
echo "<input type='text' name='phone_no' id='phone_no'><br>";
echo "Email: " . $data["Email"];
echo "<input type='text' name='email' id='email'><br>";
echo "<button onclick='update_info()'>Update Info</button>";
echo "</form>";
?>
<br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/homepage.php">Homepage</a>
<script>
  function update_info(){
  var cid = "<?php echo $_SESSION['cid']; ?>";
  var name = document.getElementById("name").value;
  
  //http://afsaccess1.njit.edu/~jjl37/database/part3/info/middle_update_info.php
}
</script>
</body>
</html>