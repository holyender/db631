<!DOCTYPE HTML>
<!--This page is for a valid customer to manage their information 
such as their name, address, and phone number. -->
<html>
<head>
</head>
<body>
<?php
 // check if we are properly logged in, if not then send us to the login screen
session_start();
if(!isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/index.php");
}

// get the current information about the user
$data = array("cid" => $_SESSION['cid']);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/info/middle_get_info.php";
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
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/homepage.php">Homepage</a>
<script>
function update_info(){
  // the update_info function will collect the data from the
  // html form for the customer to update their information
  // and will send towards the backend to be updated
  var cid = "<?php echo $_SESSION['cid']; ?>";
  var name = document.getElementById("name").value;
  var address = document.getElementById("address").value;
  var phone_no = document.getElementById("phone_no").value;
  var email = document.getElementById("email").value;

  var data = {"cid":cid, "name":name, "address":address, "phone_no":phone_no, "email":email};
  var data_json = JSON.stringify(data);

  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/info/middle_update_info.php";

  xhttp.onreadystatechange = function(){
    if(this.status == 200 && this.readyState == 4){
      location.reload();
    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);
  //  document.write(xhttp.reponseText);
}
</script>
</body>
</html>