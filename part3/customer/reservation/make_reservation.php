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
session_start();
if(!isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/login/index.php");
}

echo "Hello " . $_SESSION['name'];
?>
<br><br>
<form autocomplete="off">
<input type="text" name="country" id="country" placeholder="Country">
<br>
<input type="text" name="state" id="state" placeholder="State">
<br>
<input type="text" name="zip" id="zip" placeholder="Zip">
<br>
<input type="button" onclick="search_hotels()" value="Search">
</form>
<br>
<table id="hotels_table" align="center">
<caption>Hotels</caption>
<thead>
<tr>
<th>Hotel ID</th>
<th>Street</th>
<th>Country</th>
<th>State</th>
<th>Zip</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/homepage.php">Homepage</a>

<script>
function search_hotels(){
  var country = document.getElementById("country").value;
  var state = document.getElementById("state").value;
  var zip = document.getElementById("zip").value;

  var data = {"country":country, "state":state, "zip":zip};
  var data_json = JSON.stringify(data);

  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_search.php";

  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var data = JSON.parse(this.responseText);
      for(var i=0; i < data.length; i++){
	
      }
    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);

  
}
</script>
</body>
</html>