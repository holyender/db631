<!DOCTYPE HTML>
<!-- This file is ment so a customer can reserve a room.
The following functionality will be presented on this page:

1. Firstly the customer can search for hotels providing a 
form a country or state. Both peieces of information do not have
to be provided. A customer can provide only a country or just a state
without the other peiece of information. The customer can also provide
no information, and in that case all of the hotels will be listed.
Hence a valid search can be a state such as NJ.
Hence a valid search can be a state and country NJ and USA.
Hench a valid search can be NULL.
Hench a valid search can be a country USA.

2. The customer can then search for rooms in a given hotel. The customer
  will provide a hotel identification number, what room type they are interested in
  and the check in date for discount information.

3. The customer can reserve a room in a hotel by providing
  the hotel indentification number, the room number, and their check in date.
-->
<html>
<head>
<style>
table, th, td{
 border: 1px solid black;
 border-collapse: collapse;
 padding: 5px;
}
input[type=text]{
width: 256px;
}
</style>
</head>
<body>
<script>
function increase_colspan(id){
  // the increase_colspan function will increase the column span
  // of a given its identification
  document.getElementById(id).colSpan += 1;
}
</script>
<?php
  /* if the user is not properly logged in, then send us back to the login screen */
session_start();
if(!isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/login/index.php");
}

echo "Hello " . $_SESSION['name'];
?>
<br><br>
<!-- 
1. Firstly the customer can search for hotels providing a 
form a country or state. Both peieces of information do not have
to be provided. A customer can provide only a country or just a state
without the other peiece of information. The customer can also provide
no information, and in that case all of the hotels will be listed.
Hence a valid search can be a state such as NJ.
Hence a valid search can be a state and country NJ and USA.
Hench a valid search can be NULL.
Hench a valid search can be a country USA.
-->
Search for Hotels
<form id="search_for_hotels_form" autocomplete="off">
<input type="text" name="country" id="country" placeholder="Country">
<br>
<input type="text" name="state" id="state" placeholder="State">
<br>
<input type="button" onclick="search_hotels()" value="Search">
</form>
<br>
<!-- table to show hotel search results -->
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
<!--
2. The customer can then search for rooms in a given hotel. The customer
  will provide a hotel identification number, what room type they are interested in
  and the check in date for discount information.
-->
Search for Rooms
<form id="search_for_rooms_form" autocomplete="off">
<input type="text" name="hotelid" id="hotelid" placeholder="Hotel ID">
<br>
<input type="text" name="rtype" id="rtype" placeholder="Room Type">
<br>
<input type="text" name="checkindate" id="checkindate" placeholder="Check In Date YYYY-MM-DD">
<br>
<input type="button" onclick="search_rooms()" value="Search">
</form>
<div id="search_for_rooms_response">
<!-- this section is for an error message if a customer doesn't provide all the information required. -->
</div>
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
<form id="reserve_room_form" autocomplete="off">
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
<span id="reserve_room_response"></span>
<table align="center" id="room_reservations_table">
<caption>Room Reservations</caption>
<thead>
<tr>
<th colspan="2"></th> <!-- Check In / Check Out -->
<th></th> <!-- Hotel ID -->
<th colspan="6"></th> <!-- Room -->
<th id="breakfast_th">Breakfast</th> <!-- Breakfast -->
<th id="service_th">Service</th> <!-- Service -->
</tr>
<tr>
<th colspan="2">Date</th> <!-- Check In / Check Out-->
<th>Hotel</th> <!-- Hotel ID -->
<th colspan="6">Room</th> <!-- Room -->
<?php
// get all of the possible breakfasts a customer can order
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
curl_close($ch);

$data = json_decode($result);

// display all of the types of breakfasts that a customer can order
$count_breakfasts = count($data);
for($i=0; $i < $count_breakfasts; $i++){
// since we requested for distinct breakfast types
// then each breakfast type in the list is unique
// therefore we can use it as its table header identification
  echo "<th id=\"" . addslashes($data[$i]) . "\">";
  echo $data[$i];
  echo "</th>";

// increase the header column span as we add another breakfast
  if($i > 0){
    echo "<script>increase_colspan('breakfast_th');</script>";
  }
}

?>
<?php
// get all of the distinct services a customer could possibly order
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
//echo $result;
curl_close($ch);
$data = json_decode($result);

// display all of the possible services a customer can order
$count_services = count($data);
for($i=0; $i < $count_services; $i++){
// since we requested for distinct service types
// then each service type in the list is unique
// therefore we can use it as its table header identification
  echo "<th id=\"" . addslashes($data[$i]) . "\">";
  echo $data[$i];
  echo "</th>";

// as we add another service to the list, increase the column span of the service table header
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
<th>Type</th> <!-- Type of Room (suite, deluxe, ...) -->
<th>Price</th> <!-- Room Price -->
<th>Capacity</th> <!-- Room Capacity -->
<th>Discount</th> <!-- Room Discount -->
<th>Total</th> <!-- Room Total = Price less Price * Discount -->
<script>
// display the quantity a customer is ordering for each breakfast,
// how much each breakfast costs, and calculate the total for that breakfast
// the total for that breakfast means the quantity the customer ordered times the price of that breakfast
// the number of breakfasts a customer can order should not exceed the capacity of the room

var count_breakfasts = document.getElementById("breakfast_th").colSpan; 
var count_services = document.getElementById("service_th").colSpan;

var rrtable = document.getElementById("room_reservations_table");

var j = 9; // where the breakfast selection column should start on the third table row
var k = 3; // where the breafast selection column should start on the second table row
for(var i=0; i < count_breakfasts; i++){
  var cell_quant = rrtable.rows[2].insertCell(j); // the quantity for the customer per breakfast
  var cell_price = rrtable.rows[2].insertCell(j+1); // how much the breakfast costs
  var cell_total = rrtable.rows[2].insertCell(j+2); // for the total of the breakfast

  cell_quant.outerHTML = "<th>Quantity</th>";
  cell_price.outerHTML = "<th>Price</th>";
  cell_total.outerHTML = "<th>Total</th>";

  j+=3;

  var breakfast = rrtable.rows[1].cells[k].innerHTML; // find out which distinct breakfast we are adding under

  increase_colspan(breakfast.replace(/'/g, "\\'")); // escape the string if the breakfast has a weird name, and increase the span
  increase_colspan(breakfast.replace(/'/g, "\\'")); // escape the string if the breakfast has a weird name, and increase the span

  k++

  increase_colspan("breakfast_th"); 
  increase_colspan("breakfast_th");
}

for(var i=0; i < count_services; i++){
	var cell_quant = rrtable.rows[2].insertCell(j);
	var cell_price = rrtable.rows[2].insertCell(j+1);
        var cell_total = rrtable.rows[2].insertCell(j+2);
	
	cell_quant.outerHTML = "<th>Include</th>"; // for the checkbox so a customer can select the service
  	cell_price.outerHTML = "<th>Price</th>"; // the price of the service
        cell_total.outerHTML = "<th>Total</th>"; // the total for the service

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
<form id="credit_card_form" autocomplete="off">
<input type="text" id="cnumber" placeholder="Credit Card Number">
<br>
<select id="ctype">
<option value="Visa">Visa</option>
<option value="Master">Master</option>
<option value="Discover">Discover</option>
<option value="Amex">Amex</option>
</select>
<br>
<input type="text" id="baddress" placeholder="Billing Address">
<br>
<input type="text" id="code" placeholder="Code">
<br>
<input type="text" id="expdate" placeholder="Expiration Date YYYY-MM-DD">
<br>
<input type="text" id="name" placeholder="Name">
<br><br>
<input type="button" onclick="finalize_reservation()" value="Finalize">
</form>
<br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/homepage.php">Homepage</a>
<script>
function search_hotels(){
   // the search_hotels function will collect the information provided
   // in the search hotels section and will populate the table 
   //with information returned by the backend 
  var country = document.getElementById("country").value;
  var state = document.getElementById("state").value;

  var data = {"country":country, "state":state};
  var data_json = JSON.stringify(data);

  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_search_hotels.php";

  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var data = JSON.parse(this.responseText);
      
      // data format
      // (
      // (hotelid, street, country, state, zip),
      // (hotelid, street, country, state, zip),
      // ...,
      // (hotelid, street, country, state, zip)
      // )

      var htable = document.getElementById("hotels_table");
      var htable_rows = htable.getElementsByTagName('tr');
      var count_htable_rows = htable_rows.length;
      
      // delete the existing data in the taable
      // not including the table headers before
      // we insert the new data
      for(var i = count_htable_rows-1; i > 0; i--){
	htable.deleteRow(i);
      }
      
      // insert the new query into the table
      for(var i=0; i < data.length; i++){
      	var hotel = data[i];
	var hotelid = hotel[0];
	var street = hotel[1];
	var country = hotel[2];
	var state = hotel[3];
	var zip = hotel[4];

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
  //  document.write(xhttp.responseText);

}

function search_rooms(){
  // the search_rooms function collects the data the customer provided
  // in the form under the search for rooms section
  // if the customer did not provide all of the information
  // then an error message will be returned
  // if all of the information is provided, then the data will be sent to the backend to be processed
  // the backend should search all of the rooms that are available in the given hotel 
  // that the customer provided with a given room type that the customer also provided
  // if someone else hasn't already booked that room during the check in date, which the customer also provides
  // once the data returns from the back end with all of the rooms that are available,
  // the table will be populated with the new information
  var hotelid = document.getElementById("hotelid").value;
  var rtype = document.getElementById("rtype").value;
  var checkindate = document.getElementById("checkindate").value;

  if(!checkindate || !hotelid || !rtype){
    document.getElementById("search_for_rooms_response").innerHTML = "Provide all information.";
    return;
  }

  var data = {"hotelid":hotelid, "rtype":rtype, "checkindate":checkindate};
  var data_json = JSON.stringify(data);

  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_search_rooms.php";

  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var data = JSON.parse(this.responseText);

      // data format
      // (
      // (hotelid, roomno, rtype, price, capacity, discount),
      // (hotelid, roomno, rtype, price, capacity, discount),
      // ...,
      // (hotelid, roomno, rtype, price, capacity, discount)
      // )

      /* put the searched data in the table */
      var rtable = document.getElementById("rooms_table");
      var rtable_rows = rtable.getElementsByTagName("tr");
      var count_rtable_rows = rtable_rows.length;
      
      // before we populate the table with the new information though
      // delete all of the old information from the table
      // excluding the header of the table
      for(var i = count_rtable_rows-1; i > 0; i--){
	rtable.deleteRow(i);
      }

      // now that we got a fresh table without old room information,
      // populate it with the new information
      for(var i=0; i < data.length; i++){
	var room = data[i];
	var hotelid = room[0];
	var roomno = room[1];
        var rtype = room[2];
	var price = room[3];
	var capacity = room[4];
	var discount = room[5];
	if(!discount){
	  discount = 0.0000;
	}

	var row = rtable.insertRow(i+1);
	var cell0 = row.insertCell(0); // hotelid
	var cell1 = row.insertCell(1); // roomno
	var cell2 = row.insertCell(2); // rtype
	var cell3 = row.insertCell(3); // price
	var cell4 = row.insertCell(4); // capacity
        var cell5 = row.insertCell(5); // discount
        var cell6 = row.insertCell(6); // total

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
  /*
    the reserve_room function will collect all of the information
    that the customer provided in the reserve room form.
    if some of the information is missing, then a error response will appear.
    only when all of the reservation information is provided will the data be 
    sent to the back end for processing. the back end should return information
    about a specific room in a specifc hotel, such as how many people can stay
    in that room and which breakfasts and services are offered for that room in that hotel.
   */
  var hotelid = document.getElementById("resv_hotelid").value;
  var roomno = document.getElementById("resv_roomno").value;
  var checkindate = document.getElementById("resv_checkindate").value;
  var checkoutdate = document.getElementById("resv_checkoutdate").value;

  /* if all of the information is not provided, return an error message */
  if(!hotelid || !roomno || !checkindate || !checkoutdate){
    document.getElementById("reserve_room_response").innerHTML = "Provide all information.";
    return;
  }
  /* if an error message was just returned, and now the customer has provided all the information,
   refresh the error message section */
  else{
    document.getElementById("reserve_room_response").innerHTML = "";
  }

  var data = {"hotelid":hotelid, "roomno":roomno, "checkindate":checkindate, "checkoutdate":checkoutdate};
  var data_json = JSON.stringify(data);

  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_reserve_room.php";

  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var data = JSON.parse(this.responseText);
      //document.write(this.response);
      // if the room is not availble, then return an error message
      if(data.hasOwnProperty("response")){
	document.getElementById("reserve_room_response").innerHTML = "Room is not available during dates.";
	return;
      }
      // if there was just an error message returned, and now the customer has provided a different
      // check out or check out period or the room has just become available, then refresh the error section
      else{
	document.getElementById("reserve_room_response").innerHTML = "";
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
      // add all of the static cells
      var cell0 = row.insertCell(0); // check in date
      var cell1 = row.insertCell(1); // check out date
      var cell2 = row.insertCell(2); // hotel id
      var cell3 = row.insertCell(3); // room no
      var cell4 = row.insertCell(4); // room type
      var cell5 = row.insertCell(5); // room price
      var cell6 = row.insertCell(6); // room capacity
      var cell7 = row.insertCell(7); // room discount
      var cell8 = row.insertCell(8); // total price for room

      cell0.innerHTML = data[0]; // check in date
      cell1.innerHTML = data[1]; // check out date
      cell2.innerHTML = data[2]; // hotel id
      cell3.innerHTML = data[3]; // room no 
      cell4.innerHTML = data[4]; // rtype
      cell5.innerHTML = data[5]; // rprice
      cell6.innerHTML = data[6]; // capacity
      cell7.innerHTML = data[7]; // discount
      cell8.innerHTML = data[5] - (data[5] * data[7]); // total price for room

      var breakfasts = data[8]; // breakfasts
      var services = data[9]; // data[9] services

      var count_cell = 9; // where the breakfasts should start
      
      // display all of the data for the breakfasts
      for(var i=0; i < breakfasts.length; i++){
	var quant_cell = row.insertCell(count_cell);
	var price_cell = row.insertCell(count_cell+1);
	var total_cell = row.insertCell(count_cell+2);

	if(breakfasts[i][1]){
	  quant_cell.outerHTML = "<td><input type='number' value='0' min='0' onclick='check_limit(); calc_total();'></td>";
	  price_cell.innerHTML = breakfasts[i][1];
	  total_cell.innerHTML = "0.00";
	}
	else{
	  quant_cell.outerHTML = "<td><input type='number' value='0' min='0' max='0'></td>";
	  price_cell.innerHTML = "0.00";
	  total_cell.innerHTML = "0.00";
	}

	count_cell += 3;
      } // end of for i < breakfasts.length

      // display all of the data for the servies
      for(var i=0; i < services.length; i++){
	var include_cell = row.insertCell(count_cell);
	var price_cell = row.insertCell(count_cell+1);
	var total_cell = row.insertCell(count_cell+2);
	
	if(services[i][1]){
	  include_cell.outerHTML = "<td><input type='checkbox' onclick='calc_total()'></td>";
	  price_cell.innerHTML = services[i][1];
	  total_cell.innerHTML = 0.00;
	}
	else{
	  include_cell.outerHTML = "<td><input type='checkbox' onclick='this.checked=!this.checked'></td>";
	  price_cell.innerHTML = 0.00;
	  total_cell.innerHTML = 0.00;
	}

	count_cell += 3;
      }

    } // end of if this.status and this.readyState
  };
      
  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);
  //  document.write(xhttp.responseText);
  
}

function check_limit(){
  // the check_limit function checks if the total selected breakfasts in a row
  // exceed the capacity of the room
  // if the total selected breakfasts for a row exceed the capacity of that room,
  // then the check_limit function will reset all of the breakfast quantities in that row to 0
  
  // find out many breakasts there so in order to determine how much to increament the iterator
  var count_breakfasts = document.getElementById("room_reservations_table").rows[0].cells[3].colSpan;
  var count_rows = document.getElementById("room_reservations_table").rows.length;
  
  for(var i=3; i < count_rows; i++){
    var capacity = document.getElementById("room_reservations_table").rows[i].cells[6].innerHTML;
    capacity = parseInt(capacity);

    var count = 0;
    for(var j=0; j < count_breakfasts; j+=3){
      var quantity = document.getElementById("room_reservations_table").rows[i].cells[9+j].getElementsByTagName("input")[0].value;
      count += parseInt(quantity);
    }

    if(count > capacity){
      // reset all of the values in that row
      for(var j=0; j < count_breakfasts; j+=3){
	document.getElementById("room_reservations_table").rows[i].cells[9+j].getElementsByTagName("input")[0].value = 0;
      }
    }
  }
  
}

function finalize_reservation(){
  // the finalize_reservation function will collect
  // all of the data from the room reservations table
  // these are room reservations that includes breakfasts and services
  // that the customer wants to make
  // then it will create the reservation
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

  // get cid
  var cid = "<?php echo $_SESSION['cid']; ?>";
  data.push(cid);

  // get credit card info
  var cnumber = document.getElementById("cnumber").value;
  var ctype = document.getElementById("ctype").value;
  var baddress = document.getElementById("baddress").value;
  var code = document.getElementById("code").value;
  var expdate = document.getElementById("expdate").value;
  var name = document.getElementById("name").value;

  var credit_card = [];
  credit_card.push(cnumber);
  credit_card.push(ctype);
  credit_card.push(baddress);
  credit_card.push(code);
  credit_card.push(expdate);
  credit_card.push(name);

  data.push(credit_card);

  for(var i=3; i < count_rrtable_rows; i++){
    var row = []; // a table row

    for(var j=0; j < 9; j++){
      var cell = rrtable_rows[i].cells[j].innerHTML;
      row.push(cell);
    }

    var k = 3; // to get breakfast or service type
    var breakfasts = []; // breakfasts in row

    for(var j=0; j < breakfast_cells; j+=3){
      var breakfast = [];

      var cell = rrtable_rows[1].cells[k].innerHTML; // btype
      breakfast.push(cell);
      k++;
      
      cell = rrtable_rows[i].cells[9+j].getElementsByTagName("input")[0].value; // quantity
      breakfast.push(cell);

      cell = rrtable_rows[i].cells[9+j+1].innerHTML; // price
      breakfast.push(cell);

      cell = rrtable_rows[i].cells[9+j+2].innerHTML; // total
      breakfast.push(cell);
      
      breakfasts.push(breakfast);
    }
    
    row.push(breakfasts);

    var services = []; // services in row

    for(var j=0; j < service_cells; j+=3){
      var service = [];

      var cell = rrtable_rows[1].cells[k].innerHTML; // stype
      k++;
      service.push(cell);

      cell = rrtable_rows[i].cells[9+breakfast_cells+j].getElementsByTagName("input")[0].value; // quantity
      service.push(cell);

      cell = rrtable_rows[i].cells[9+breakfast_cells+j+1].innerHTML;      // price
      service.push(cell);

      cell = rrtable_rows[i].cells[9+breakfast_cells+j+2].innerHTML;      // total
      service.push(cell);
      
      services.push(service);
    }

    row.push(services);

    data.push(row);
  }

  var data_json = JSON.stringify(data);
  
  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reservation/middle_finalize_reservation.php";

  xhttp.onreadystatechange = function(){
    if(this.status == 200 && this.readyState == 4){
      location.reload();
    } // end of if readyState and status
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);  
  //document.write(xhttp.responseText);
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
      var check = rrtable.rows[i].cells[9+count_breakfasts+k].getElementsByTagName("input")[0].checked;
      var price = rrtable.rows[i].cells[9+count_breakfasts+k+1].innerHTML;
      var total;
      if(check){
	total = price;
      }
      else{
	total = 0.00;
      }

      rrtable.rows[i].cells[9+count_breakfasts+k+2].innerHTML = total;
    }

  }

}
</script>
</body>
</html>
