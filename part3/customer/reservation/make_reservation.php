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
<tr>
<th>Hotel ID</th>
<th>Room No</th>
<th>Type</th>
<th>Price</th>
<th>Capacity</th>
<th>Discount</th>
<th>Total</th>
</tr>
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
<span id="response"></span>
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
<div style="text-align: center">
<button onclick="finalize_reservation()">Finalize</button>
</div>
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

  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var data = JSON.parse(this.responseText);
      
      if(data.hasOwnProperty("response")){
	document.getElementById("response").innerHTML = data["response"];
	return;
      }
      else{
	document.getElementById("response").innerHTML = "";
      }
      
      // data format
      // (
      // hotelid, roomno, checkindate, checkoutdate,
      // rtype, price, capacity, discount, (breakfasts), (services)
      // )
      // (breakfasts) -> (btype, price, btype, price, ..., btype, price)
      // (services) -> (stype, price, stype, price, ..., stype, price)

      var rrtable = document.getElementById("room_reservations_table");
      var rrtable_rows = rrtable.getElementsByTagName("tr");
      var count_rrtable_rows = rrtable_rows.length;
      
      var row = rrtable.insertRow(count_rrtable_rows);
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
      var cell3 = row.insertCell(3);
      var cell4 = row.insertCell(4);
      var cell5 = row.insertCell(5);
      var cell6 = row.insertCell(6);
      var cell7 = row.insertCell(7);
      var cell8 = row.insertCell(8);

      cell0.innerHTML = data["checkindate"];
      cell1.innerHTML = data["checkoutdate"];
      cell2.innerHTML = data["hotelid"];
      cell3.innerHTML = data["roomno"];
      cell4.innerHTML = data["0"]; // rtype
      cell5.innerHTML = data["1"]; // rprice
      cell6.innerHTML = data["2"]; // capacity
      cell7.innerHTML = data["3"]; // discount
      cell8.innerHTML = data["1"] - (data["1"] * data["3"]);
      // data["4"] breakfasts
      // data["5"] services

      var count_cell = 9;
      // insert breakfasts
      for(var i=0; i < data["4"].length; i+=2){
	var cell_quant = row.insertCell(count_cell);
	var cell_price = row.insertCell(count_cell+1);
	var cell_total = row.insertCell(count_cell+2);

	if(data["4"][i+1]){
	  cell_quant.outerHTML = "<td><input type=\"number\" min=\"0\" value=\"0\" onclick=\"calc_total()\"></td>"; 
	  cell_price.innerHTML = data["4"][i+1];
	  cell_total.innerHTML = "0.00";
	}
	else{
	  cell_quant.outerHTML = "<td><input type=\"number\" value=\"0\" min=\"0\" max=\"0\"></td>";
	  cell_price.innerHTML = "0.00";
	  cell_total.innerHTML = "0.00";
	}

	count_cell+=3;
      }

      // insert services
      for(var i=0; i < data["5"].length; i+=2){
	var cell_quant = row.insertCell(count_cell);
	var cell_price = row.insertCell(count_cell+1);
	var cell_total = row.insertCell(count_cell+2);

	if(data["5"][i+1]){
	  cell_quant.outerHTML = "<td><input type=\"number\" min=\"0\" value=\"0\" onclick=\"calc_total()\"></td>"; 
	  cell_price.innerHTML = data["5"][i+1];
	  cell_total.innerHTML = "0.00";
	}
	else{
	  cell_quant.outerHTML = "<td><input type=\"number\" value=\"0\" min=\"0\" max=\"0\"></td>";
	  cell_price.innerHTML = "0.00";
	  cell_total.innerHTML = "0.00";
	}
	
	count_cell+=3;
      }

    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);
  //  document.write(xhttp.responseText);
}

function finalize_reservation(){
  var date_cells = 2;
  var hotel_cells = 1;
  var room_cells = 6;
  var breakfast_cells = document.getElementById("breakfast_th").colSpan;
  var service_cells = document.getElementById("service_th").colSpan;

  // number of cells needed to be collected
  var cells = date_cells + hotel_cells + room_cells + breakfast_cells + service_cells;

  var rrtable = document.getElementById("room_reservations_table");
  var rrtable_rows = rrtable.getElementsByTagName("tr");
  var count_rrtable_rows = rrtable_rows.length;
  
  var data = [];
  for(var i=3; i < count_rrtable_rows; i++){
    var row = [];

    for(var j=0; j < cells; j++){
      var cell;

      if(j < 9){
	cell = rrtable_rows[i].cells[j].innerHTML;
	row.push(cell);
      }
      else{
	cell = rrtable_rows[i].cells[j].getElementsByTagName("input")[0].value;
	document.write(cell);
	row.push(cell);
	j++;

	cell = rrtable_rows[i].cells[j].innerHTML;
	row.push(cell);
	j++;

	cell = rrtable_rows[i].cells[j].innerHTML;
	row.push(cell);
      }
       
    }

    data.push(row);
  }

  var data_json = JSON.stringify(data);
  
  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_finalize_reservation.php";

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);  
  document.write(xhttp.responseText);
}

function calc_total(){
  var rrtable = document.getElementById("room_reservations_table");
  var rrtable_rows = rrtable.getElementsByTagName("tr");
  var count_rrtable_rows = rrtable_rows.length;
  var count_breakfasts = document.getElementById("breakfast_th").colSpan;
  var count_services = document.getElementById("service_th").colSpan;

  for(var i=3; i < count_rrtable_rows; i++){

    // calculate totals for breakfasts
    for(var j=0; j < count_breakfasts; j+=3){
      var quantity = rrtable.rows[i].cells[9+j].getElementsByTagName("input")[0].value;
      var price = rrtable.rows[i].cells[9+j+1].innerHTML;
      var total = parseInt(quantity) * parseFloat(price);

      rrtable.rows[i].cells[9+j+2].innerHTML = total;

    }

    // calculate totals for services
    for(var k=0; k < count_services; k+=3){
      var quantity = rrtable.rows[i].cells[9+count_breakfasts+k].getElementsByTagName("input")[0].value;
      var price = rrtable.rows[i].cells[9+count_breakfasts+k+1].innerHTML;
      var total = parseInt(quantity) * parseFloat(price);

      rrtable.rows[i].cells[9+count_breakfasts+k+2].innerHTML = total;
    }

  }

}
</script>
</body>
</html>
