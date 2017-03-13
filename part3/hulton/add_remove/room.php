<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<form method="post" action="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/add_remove/middle_room.php" autocomplete="off">
<input type="text" name="hotelid" placeholder="HotelID" required>
<br>
<input type="text" name="roomno" placeholder="Room Number" required>
<br>
<input type="text" name="floor" placeholder="Floor" required>
<br>
<input type="text" name="rtype" placeholder="Type">
<br>
<input type="text" name="price" placeholder="Price">
<br>
<input type="text" name="capacity" placeholder="Capacity">
<br>
<textarea name="description" placeholder="Description"></textarea>
<br>
<select name="request">
<option value="add">Add</option>
<option value="remove">Remove</option>
</select>
<br><br>
<input type="submit" value="Submit">
</form>
<br>
<a href="http://afsaccess1.njit.edu/~jjl37/database/part3/hulton/rooms.php">Go Back to Rooms</a>
</body>
</html>