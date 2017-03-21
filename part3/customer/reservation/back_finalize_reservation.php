<?php
  // this file is ment to finalize the reservation

$data_json = file_get_contents('php://input');
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
// (services) -> ((service, (service), ..., (service))
// (service) -> (stype, quantity, sprice, total)

include('../../config.php');

$count_room_reservations = count($data) - 2; // exlcude the cid and credit card

$cid = (int)$data[0];

$credit_card = $data[1];
$cnumber = (int)$credit_card[0];
$ctype = $credit_card[1];
$baddress = $credit_card[2];
$code = (int)$credit_card[3];
$expdate = $credit_card[4];
$name = $credit_card[5];

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
/*
else if(1 <= $count){
  // the card exists in the system
  $sql = "select Ctype, Baddress, Code, ExpDate, Name from CREDIT_CARD where CNumber=$cnumber";

  $result = mysqli_query($conn, $sql);
  if(!$result){
    echo "query error: " . mysqli_error($conn);
    exit;
  }

  $card = mysqli_fetch_assoc($result);
  $card_ctype = $card['Ctype'];
  $card_baddress = $card['Baddress'];
  $card_code = (int)$card['Code'];
  $card_expdate = $card['ExpDate'];
  $card_name = $card['Name'];

  // check if everything matches
  // if not return error message
  if(strcmp($card_ctype, $ctype) != 0){
    $data = array("response" => "invalid credit card");
    $data_json = json_encode($data);
    exit;
  }
  
  if(strcmp($card_baddress, $baddress) != 0){
    $data = array("response" => "invalid credit card");
    $data_json = json_encode($data);
    exit;
  }

  if($card_code != $code){
    $data = array("response" => "invalid credit card");
    $data_json = json_encode($data);
    exit;
  }

  if(strcmp($card_expdate, $expdate) != 0){
    $data = array("response" => "invalid credit card");
    $data_json = json_encode($data);
    exit;
  }

  if(strcmp($card_name, $name) != 0){
    $data = array("response" => "invalid credit card");
    $data_json = json_encode($data);
    exit;
  }

}
*/

$rdate = date("Y-m-d"); // get the current date
// create a reservation
$sql = "insert into RESERVATION (CID, Cnumber, RDate) values ($cid, $cnumber, '$rdate')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "select MAX(InvoiceNo) as InvoiceNo from RESERVATION where CID=$cid and Cnumber=$cnumber";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$row = mysqli_fetch_assoc($result);
$invoiceno = $row['InvoiceNo'];

for($i=0; $i < $count_room_reservations; $i++){
  //TODO  
}

$data_json = json_encode($data);
//echo $data_json;

?>