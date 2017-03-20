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
<script>
function increase_colspan(id){
  document.getElementById(id).colSpan += 1;
}
</script>
<?php
session_start();
if(!isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/login/index.php");
}

echo "Hello " . $_SESSION['name'];
?>
<br><br>
Search for Hotels
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
Search for Rooms
<form autocomplete="off">
<input type="text" name="hotelid" id="hotelid" placeholder="Hotel ID">
<br>
<input type="text" name="rtype" id="rtype" placeholder="Room Type">
<br>
<input type="text" name="checkindate" id="checkindate" placeholder="Check In Date YYYY-MM-DD">
<br>
<input type="button" onclick="search_rooms()" value="Search">
</form>
<table id="rooms_table" align="center">
<caption>Rooms</caption>
<thead>
<th>Hotel ID</th>
<th>Room No</th>
<th>Type</th>
<th>Price</th>
<th>Capacity</th>
<th>Discount</th>
<th>Total</th>
</thead>
<tbody>
</tbody>
</table>
<br>
Reserve Room
<form autocomplete="off">
<input type="text" name="resv_hotelid" id="resv_hotelid" placeholder="Hotel ID">
<br>
<input type="text" name="resv_roomno" id="resv_roomno" placeholder="Room No">
<br>
<input type="text" name="resv_checkindate" id="resv_checkindate" placeholder="Check In Date YYYY-MM-DD">
<br>
<input type="text" name="resv_checkoutdate" id="resv_checkoutdate" placeholder="Check Out Date YYYY-MM-DD">
<br>
<input type="button" onclick="reserve_room()" value="Reserve">
</form>
<table align="center" id="room_reservations_table">
<caption>Room Reservations</caption>
<thead>
<tr>
<th colspan="2"></th> <!-- Check In / Check Out -->
<th></th> <!-- Hotel ID -->
<th colspan="6"></th>
<th id="breakfast_th">Breakfast</th>
<th id="service_th">Service</th>
</tr>
<tr>
<th colspan="2">Date</th> <!-- Check In / Check Out-->
<th>Hotel</th> <!-- Hotel ID -->
<th colspan="6">Room</th>
<?php
$data = array("info" => "breakfasts");
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_get_info.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

//echo $result;

$data = json_decode($result);

$count_breakfasts = count($data);
for($i=0; $i < $count_breakfasts; $i++){
  echo "<th id=\"" . addslashes($data[$i]) . "\">";
  echo $data[$i];
  echo "</th>";

  if($i > 0){
    echo "<script>increase_colspan('breakfast_th');</script>";
  }
}

?>
<?php

$data = array("info" => "services");
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_get_info.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

$data = json_decode($result);

$count_services = count($data);
for($i=0; $i < $count_services; $i++){
  echo "<th id=\"" . addslashes($data[$i]) . "\">";
  echo $data[$i];
  echo "</th>";

  if($i > 0){
    echo "<script>increase_colspan('service_th');</script>";
  }
}

?>
</tr>
<tr>
<th>Check In</th>
<th>Check Out</th>
<th>ID</th>
<th>No</th>
<th>Type</th>
<th>Price</th>
<th>Capacity</th>
<th>Discount</th>
<th>Total</th>
<script>
var count_breakfasts = document.getElementById("breakfast_th").colSpan;
var count_services = document.getElementById("service_th").colSpan;

var rrtable = document.getElementById("room_reservations_table");

var j = 9; // cell number 
var k = 3;
for(var i=0; i < count_breakfasts; i++){
  var cell_quant = rrtable.rows[2].insertCell(j);
  var cell_price = rrtable.rows[2].insertCell(j+1);
  var cell_total = rrtable.rows[2].insertCell(j+2);

  cell_quant.outerHTML = "<th>Quantity</th>";
  cell_price.outerHTML = "<th>Price</th>";
  cell_total.outerHTML = "<th>Total</th>";

  j += 3;

  var breakfast = rrtable.rows[1].cells[k].innerHTML;
  increase_colspan(breakfast.replace(/'/g, "\\'"));
  increase_colspan(breakfast.replace(/'/g, "\\'"));
  k++;
  increase_colspan("breakfast_th");
  increase_colspan("breakfast_th");
}

for(var i=0; i < count_services; i++){
	var cell_quant = rrtable.rows[2].insertCell(j);
	var cell_price = rrtable.rows[2].insertCell(j+1);
        var cell_total = rrtable.rows[2].insertCell(j+2);
	
	cell_quant.outerHTML = "<th>Quantity</th>";
  	cell_price.outerHTML = "<th>Price</th>";
        cell_total.outerHTML = "<th>Total</th>";

	j += 3;

	var service = rrtable.rows[1].cells[k].innerHTML;
	increase_colspan(service.replace(/'/g, "\\'"));
	increase_colspan(service.replace(/'/g, "\\'"));
	k++;
	increase_colspan("service_th");
	increase_colspan("service_th");
}

</script>
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
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_search_hotels.php";

  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var data = JSON.parse(this.responseText);
      
      var htable = document.getElementById("hotels_table");
      var htable_rows = htable.getElementsByTagName('tr');
      var count_htable_rows = htable_rows.length;
      
      // delete existing data, not including the table headers
      for(var i = count_htable_rows-1; i > 0; i--){
	htable.deleteRow(i);
      }
      
      for(var i=0; i < data.length; i++){
      	var hotel = data[i];
	var hotelid = data[i][0];
	var street = data[i][1];
	var country = data[i][2];
	var state = data[i][3];
	var zip = data[i][4];

	var row = htable.insertRow(i+1);
	var cell0 = row.insertCell(0);
	var cell1 = row.insertCell(1);
	var cell2 = row.insertCell(2);
	var cell3 = row.insertCell(3);
	var cell4 = row.insertCell(4);

	cell0.innerHTML = hotelid;
	cell1.innerHTML = street;
	cell2.innerHTML = country;
	cell3.innerHTML = state;
	cell4.innerHTML = zip;
      }
      
    }
    
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);

}

function search_rooms(){
  var hotelid = document.getElementById("hotelid").value;
  var rtype = document.getElementById("rtype").value;
  var checkindate = document.getElementById("checkindate").value;

  var data = {"hotelid":hotelid, "rtype":rtype, "checkindate":checkindate};
  var data_json = JSON.stringify(data);

  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_search_rooms.php";

  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var data = JSON.parse(this.responseText);

      var rtable = document.getElementById("rooms_table");
      var rtable_rows = rtable.getElementsByTagName("tr");
      var count_rtable_rows = rtable_rows.length;
      
      for(var i = count_rtable_rows-1; i > 0; i--){
	rtable.deleteRow(i);
      }

      for(var i=0; i < data.length; i++){
	var room = data[i];
	var hotelid = data[i][0];
	var roomno = data[i][1];
        var rtype = data[i][2];
	var price = data[i][3];
	var capacity = data[i][4];
	var discount = data[i][5];
	if(!discount){
	  discount = 0.0000;
	}

	var row = rtable.insertRow(i+1);
	var cell0 = row.insertCell(0);
	var cell1 = row.insertCell(1);
	var cell2 = row.insertCell(2);
	var cell3 = row.insertCell(3);
	var cell4 = row.insertCell(4);
        var cell5 = row.insertCell(5);
        var cell6 = row.insertCell(6);

	cell0.innerHTML = hotelid;
	cell1.innerHTML = roomno;
        cell2.innerHTML = rtype;
	cell3.innerHTML = price;
	cell4.innerHTML = capacity;
        cell5.innerHTML = discount;
        cell6.innerHTML = (price - (price * discount)).toFixed(2);

      }

    }

  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);
//  document.write(xhttp.responseText);
  
}

function reserve_room(){
  var hotelid = document.getElementById("resv_hotelid").value;
  var roomno = document.getElementById("resv_roomno").value;
  var checkindate = document.getElementById("resv_checkindate").value;
  var checkoutdate = document.getElementById("resv_checkoutdate").value;

  var data = {"hotelid":hotelid, "roomno":roomno, "checkindate":checkindate, "checkoutdate":checkoutdate};
  var data_json = JSON.stringify(data);

  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_reserve_room.php";

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);
  document.write(xhttp.responseText);
}

</script>
</body>
</html>
