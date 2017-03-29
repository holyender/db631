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
<form autocomplete="off">
<input type="text" id="begin_date" placeholder="Begin Date YYYY-MM-DD" required>
<br>
<input type="text" id="end_date" placeholder="End Date YYYY-MM-DD" required>
<br>
<input type="button" value="Submit" onclick="compute_highest_rated_room_type_for_each_hotel(); compute_five_best_customers(); compute_highest_rated_breakfast_type(); compute_highest_rated_service_type();">
</form>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/homepage.php">Homepage</a>
<br><br>
<table id="highest_room_type" align="center">
<caption>Highest Room Type</caption>
<thead>
<tr>
<th>HotelID</th>
<th>Room Type</th>
</tr>
</thead>
<tbody>
</body>
</table>
<br><br>
<table id="best_customers" align="center">
<caption>Best Customers</caption>
<thead>
<tr>
<th>CID</th>
<th>Name</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<br><br>
<table id="highest_breakfast_type" align="center">
<caption>Highest Breakfast Type</caption>
<thead>
<tr>
<th>HotelID</th>
<th>Type</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
<br><br>
<table id="highest_service_type" align="center">
<caption>Highest Service Type</caption>
<thead>
<th>Hotel ID</th>
<th>Type</th>
</thead>
<tbody>
</tbody>
</table>
<script>
function compute_highest_rated_room_type_for_each_hotel()
{
  /*
  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/stats/middle_highest_rated_service_type.php";

  xhttp.onreadystatechange = function(){
    if(this.status == 200 && this.readyState == 4){

    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send();
  document.write(xhttp.responseText);  
  */
}

function compute_five_best_customers(){
  /*
  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/stats/middle_highest_rated_service_type.php";

  xhttp.onreadystatechange = function(){
    if(this.status == 200 && this.readyState == 4){

    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send();
  document.write(xhttp.responseText);  
  */
}

function compute_highest_rated_breakfast_type(){
  /*
  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/stats/middle_highest_rated_service_type.php";

  xhttp.onreadystatechange = function(){
    if(this.status == 200 && this.readyState == 4){

    }
  };

  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send();
  document.write(xhttp.responseText);  
  */
}

function compute_highest_rated_service_type(){
  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/stats/middle_highest_rated_service_type.php";
  /*
  xhttp.onreadystatechange = function(){
    if(this.status == 200 && this.readyState == 4){

    }
  };
  */
  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send();
  document.write(xhttp.responseText);
}
</script>
</body>
</html>