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
<form>
<input type="text" name="city" placeholder="City">
<input type="text" name="state" placeholder="State">
<input type="text" name="zip" placeholder="Zip">
<input type="date" name="checkindate" placeholder="Check In Date YYYY-MM-DD">
<input type="date" name="checkoutdate" placeholder="Check Out Date YYYY-MM-DD">
<button onlick="search_hotels()">Search</button>
</form>
<table>
<caption>Availability</caption>
<thead>
<tr>
<th></th>
</tr>
</thead>
<tbody>
</tobdy>
</table>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/homepage.php">Homepage</a>
</body>
</html>