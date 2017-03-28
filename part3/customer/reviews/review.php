<!DOCTYPE HTML>
<html>
<head>
<style>
table, th, td{
 border: 1px solid black;
 border-collapse: collapse;
 padding: 5px;
}
input[type=number]{
width: 64px;
}
</style>
</head>
<body>
<?php
 // if we are not logged in properly as a valid customer, then send us back to the log in page
session_start();
if(!isset($_SESSION['cid'])){
  header("Location: http://afsaccess1.njit.edu/~jjl37/database/part3/customer/login/index.php");
}

echo "Hello " . $_SESSION['name'];

// figure out which rooms we can review
$data = array("cid" => $_SESSION['cid']);
$data_json = json_encode($data);

$ch = curl_init();
$url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reviews/middle_get_avail_reviews.php";
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
//echo $result;
$room_reviews = json_decode($result);

echo "<br><br>";
echo "<table id='room_review_table' align='center'>";
echo "<caption>Room Review</caption>";
echo "<thead>";
echo "<tr>";
echo "<th></th>"; // for checkbox
echo "<th>HotelID</th>";
echo "<th>RoomNo</th>";
echo "<th>Rating</th>"; // point rating for room
echo "<th>Text</th>"; // customer's input for review
echo "</tr>";
echo "</thead>";

echo "<tbody>";
$count_room_reviews = count($room_reviews);
for($i=0; $i < $count_room_reviews; $i++){
  echo "<tr>";

  $room = $room_reviews[$i];
  $hotelid = $room[0];
  $roomno = $room[1];

  echo "<td><input type='checkbox'></td>";
  echo "<td>$hotelid</td>";
  echo "<td>$roomno</td>";
  echo "<td><input type='number' min='0' value='0' max='10'></td>";
  echo "<td><textarea></textarea></td>";

  echo "</tr>";
}
echo "</tbody>";

echo "</table>";
echo "<br><br>";
echo "<div style='text-align: center;'>";
echo "<input type='button' onclick='room_review()' value='Submit Room Reviews'>";
echo "</div>";
?>
<br><br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/customer/homepage.php">Homepage</a>
<script>
function room_review(){
  var count_rows = document.getElementById("room_review_table").rows.length;
  // figure out which rooms we want to review by the check marks
  var checks = [];
  for(var i=1; i < count_rows; i++){
    var check = document.getElementById("room_review_table").rows[i].cells[0].getElementsByTagName("input")[0].checked;
    checks.push(check);
  }

  var data = [];
  var cid = "<?php echo $_SESSION['cid']; ?>";
  data.push(cid);

  for(var i=1; i < count_rows; i++){
    var check = checks[i-1];
    if(check){
      var row = [];
      var hotelid = document.getElementById("room_review_table").rows[i].cells[1].innerHTML;
      var roomno = document.getElementById("room_review_table").rows[i].cells[2].innerHTML;
      var rating = document.getElementById("room_review_table").rows[i].cells[3].getElementsByTagName("input")[0].value;
      var text = document.getElementById("room_review_table").rows[i].cells[4].getElementsByTagName("textarea")[0].value;
      row.push(hotelid);
      row.push(roomno);
      row.push(rating);
      row.push(text);
      data.push(row);
    }
  } // end of for i < count_rows

  var data_json = JSON.stringify(data);
  
  var xhttp = new XMLHttpRequest();
  var url = "http://afsaccess1.njit.edu/~jjl37/database/part3/customer/reviews/middle_submit_room_review.php";
  /*
  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      location.reload();
    }
  };
  */
  xhttp.open("POST", url, false);
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.send(data_json);
  document.write(xhttp.responseText);
}
</script>
</body>
</html>