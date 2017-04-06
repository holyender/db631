<?php
  // this file is ment to finalize the reservation
  // what we need to do to finalize the reservation is
  // we need to credit card into the system
  // but first check if the credit card exists in the system
  // if it doesn't then just put it in
  // if it does exist then update the information
  // then we will now to create a new reservation and get today's date
  // then for each of the room's we wanted to reserve, put those in
  // and for all of the breakfasts and services for that room reservation

$data_json = file_get_contents('php://input');
//var_dump($data_json);
$data = json_decode($data_json);

// $data format
// (
// cid, (credit_card), (room_reservation),
// (room_reservation), ..., (room_reservation)
// )
// (credit card) -> (cnumber, ctype, baddress, code, expdate, name)
// (room reservation) -> (checkindate, checkoutdate, hotelid, roomno,
//                        rtype, price, capacity, discount, room_total,
//                        (breakfasts), (services) )
// (breakfasts) -> ((breakfast), (breakfast), ..., (breakfast))
// (breakfast) -> (btype, quantity, bprice, total)
// (services) -> ((service), (service), ..., (service))
// (service) -> (stype, include/null, sprice, total)

include('../../config.php');

$cid = (int)$data[0];

$credit_card = $data[1];
$cnumber = (int)$credit_card[0];
$ctype = mysqli_real_escape_string($conn, $credit_card[1]);
$baddress = mysqli_real_escape_string($conn, $credit_card[2]);
$code = (int)$credit_card[3];
$expdate = mysqli_real_escape_string($conn, $credit_card[4]);
$name = mysqli_real_escape_string($conn, $credit_card[5]);

// check if the credit card doesn't exist in the system already
// if the credit card doesn't exist in the system then add it
// if the credit card does exist in the system then check if all the data is correct
$sql = "select * from CREDIT_CARD where CNumber=$cnumber";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$count = mysqli_num_rows($result);
if(0 == $count){
  // the card doesn't exist in the system
  $sql = "insert into CREDIT_CARD (CNumber, Ctype, Baddress, Code, ExpDate, Name) values ($cnumber, '$ctype', '$baddress', $code, '$expdate', '$name')";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }
} // end of if 0 == count

else if(1 <= $count){
  // the card exists in the system
  $sql = "select Ctype, Baddress, Code, ExpDate, Name from CREDIT_CARD where CNumber=$cnumber";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  // grab the info for the credit that we have stored
  // so we can compare it with what we put in 
  $card = mysqli_fetch_assoc($result);
  $card_ctype = mysqli_real_escape_string($conn, $card['Ctype']);
  $card_baddress = mysqli_real_escape_string($conn, $card['Baddress']);
  $card_code = (int)$card['Code'];
  $card_expdate = mysqli_real_escape_string($conn, $card['ExpDate']);
  $card_name = mysqli_real_escape_string($conn, $card['Name']);

  // check if everything matches
  // if something is different, update it the credit card informatio in the database
  if(strcmp($card_ctype, $ctype) != 0){
    $sql = "update CREDIT_CARD set Ctype='$ctype' where CNumber=$cnumber";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
      echo "query error: " . mysqli_error($conn);
      exit;
    }
  }
  
  if(strcmp($card_baddress, $baddress) != 0){
    $sql = "update CREDIT_CARD set Baddress='$baddress' where CNumber=$cnumber";

    $result = mysqli_query($conn, $sql);
    if(!$result){
      echo "query error: " . mysqli_error($conn);
      exit;
    }
  }

  if($card_code != $code){
    $sql = "update CREDIT_CARD set Code=$code where CNumber=$cnumber";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
      echo "query error: " . mysqli_error($conn);
      exit;
    }
  }
  
  if(strcmp($card_expdate, $expdate) != 0){
    $sql = "update CREDIT_CARD set ExpDate='$expdate' where CNumber=$cnumber";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
      echo "query error: " . mysqli_error($conn);
      exit;
    }
  }

  if(strcmp($card_name, $name) != 0){
    $sql = "update CREDIT_CARD set Name='$name' where CNumber=$cnumber";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
      echo "query error: " . mysqli_error($conn);
      exit;
    }
  }
  
}


$rdate = date("Y-m-d"); // get the current date
// create a reservation
$sql = "insert into RESERVATION (CID, Cnumber, RDate) values ($cid, $cnumber, '$rdate')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// figure out what reservation invoice number we just made	     
$sql = "select MAX(InvoiceNo) as InvoiceNo from RESERVATION where CID=$cid and Cnumber=$cnumber and RDate='$rdate'";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$row = mysqli_fetch_assoc($result);
$invoiceno = (int)$row['InvoiceNo'];

$count_room_reservations = count($data); // exlcude the cid and credit card
for($i=2; $i < $count_room_reservations; $i++){
  // (room reservation) -> (checkindate, checkoutdate, hotelid, roomno,
  //                        rtype, price, capacity, discount, room_total,
  //                        (breakfasts), (services) )
  // (breakfasts) -> ((breakfast), (breakfast), ..., (breakfast))
  // (breakfast) -> (btype, quantity, bprice, total)
  // (services) -> ((service), (service), ..., (service))
  // (service) -> (stype, quantity, sprice, total)

  // get all of the data for the room reservation
  $room_reservation = $data[$i];
  $checkindate = mysqli_real_escape_string($conn, $room_reservation[0]);
  $checkoutdate = mysqli_real_escape_string($conn, $room_reservation[1]);
  $hotelid = (int)$room_reservation[2];
  $roomno = (int)$room_reservation[3];

  $sql = "insert into ROOM_RESERVATION (InvoiceNo, HotelID, RoomNo, CheckInDate, CheckOutDate) values ($invoiceno, $hotelid, $roomno, '$checkindate', '$checkoutdate')";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  // insert all of the rresv_breakfasts
  $breakfasts = $room_reservation[9];
  $count_breakfasts = count($breakfasts);
  for($j=0; $j < $count_breakfasts; $j++){
    // (breakfasts) -> ((breakfast), (breakfast), ..., (breakfast))
    // (breakfast) -> (btype, quantity, bprice, total)
    $breakfast = $breakfasts[$j];
    $btype = mysqli_real_escape_string($conn, $breakfast[0]);
    $quantity = (int)$breakfast[1];

    if($quantity > 0){
      $sql = "insert into RRESV_BREAKFAST (Btype, HotelID, RoomNo, CheckInDate, NoofOrders) values ('$btype', $hotelid, $roomno, '$checkindate', $quantity)";

      $result = mysqli_query($conn, $sql);
      if(!$result){
	echo "query error: " . mysqli_error($conn);
	exit;
      }
    }
  } // end of for j count_breakfasts

  // insert all of the rresv_services
  $services = $room_reservation[10];
  $count_services = count($services);
  for($j=0; $j < $count_services; $j++){
    // (services) -> ((service), (service), ..., (service))
    // (service) -> (stype, include/null, sprice, total)
    $service = $services[$j];
    $stype = mysqli_real_escape_string($conn, $service[0]);
    $request = $service[1]; // whether the customer wants this service or not. true means they do. false means they don't

    if($request){
      $sql = "insert into RRESV_SERVICE (Stype, HotelID, RoomNo, CheckInDate) values ('$stype', $hotelid, $roomno, '$checkindate')";
    
      $result = mysqli_query($conn, $sql);
      if(!$result){
	echo "query error: " . mysqli_error($conn);
	exit;
      }
    }
  } // end of for j count_services

} // end of for i count_room_reservations

?>