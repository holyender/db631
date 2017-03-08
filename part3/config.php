<?php

$host = "sql2.njit.edu";
$user = "jjl37";
$pass = "richter56";
$db = "jjl37";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
  echo "connection error: " . mysqli_connect_error();
  exit;
}

?>