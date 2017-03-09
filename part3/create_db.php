<?php

include("config.php");

$sql = "create table if not exists CUSTOMER (CID int auto_increment, NAME varchar(16), ADDRESS varchar(16), Phone_no char(10), Email varchar( 16), constraint customer_pk primary key(CID))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists CREDIT_CARD (CNumber int not null, Ctype varchar(8) not null, Baddress varchar(16) not null, Code char(3) not null, ExpDate date, Name varchar(16), constraint credit_card_pk primary key(CNumber))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists HOTEL (HotelID int not null, Street varchar(16), Country varchar(16), State varchar(16), Zip varchar(16), constraint hotel_pk primary key(HotelID))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists ROOM (HotelID int not null, RoomNo int not null, Rtype varchar(16), Price decimal(5,2) not null, Description text, Floor int, Capacity int, constraint room_pk primary key(HotelID, RoomNo), constraint room_hotel_fk foreign key(HotelID) references HOTEL(HotelID) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists DISCOUNTED_ROOM (HotelID int, RoomNo int, Discount decimal(5,2) not null, StartDate date not null, EndDate date not null, constraint discounted_room_pk primary key(HotelID, RoomNo), constraint discounted_room_room_fk foreign key(HotelID, RoomNo) references ROOM(HotelID, RoomNo) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists SERVICE (HotelID int not null, SType varchar(16) not null, SPrice decimal(5,2), constraint service_pk primary key(HotelID, Stype), constraint service_hotel_fk foreign key(HotelID) references HOTEL(HotelID) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists BREAKFAST (HotelID int not null, BType varchar(16) not null, BPrice decimal(5,2) not null, Description text, constraint breakfast_pk primary key(HotelID, BType), constraint breakfast_hotel_fk foreign key(HotelID) references HOTEL(HotelID) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists ROOM_REVIEW (RID int not null, Rating int check(rating between 0 and 5), Text varchar(16), CID int, HotelID int, RoomNo int, constraint room_review_pk primary key(RID), constraint room_review_customer_fk foreign key(CID) references CUSTOMER(CID) on delete set null on update cascade, constraint room_review_room_fk foreign key(HotelID, RoomNo) references ROOM(HotelID, RoomNo) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists BREAKFAST_REVIEW (RID int not null, HotelID int, BType varchar(16), CID int, Text varchar(16), Rating int check(Rating between 0 and 5), constraint breakfast_review_pk primary key(RID), constraint breakfast_review_breakfast_fk foreign key(HotelID, BType) references BREAKFAST(HotelID, BType) on delete cascade on update cascade, constraint breakfast_review_customer_fk foreign key(CID) references CUSTOMER(CID) on delete set null on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists SERVICE_REVIEW (RID int, HotelID int, SType varchar(16), CID int, Rating int check(Rating between 0 and 5), Text varchar(16), constraint service_review_pk primary key(RID), constraint service_review_service_fk foreign key(HotelID, SType) references SERVICE(HotelID, SType) on delete cascade on update cascade, constraint service_review_customer_fk foreign key(CID) references CUSTOMER(CID) on delete set null on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists RESERVATION (InvoiceNo int not null, CID int, Cnumber int, Rdate date, constraint reservation_pk primary key(InvoiceNo), constraint reservation_customer_fk foreign key(CID) references CUSTOMER(CID) on delete cascade on update cascade, constraint reservation_credit_card_fk foreign key(Cnumber) references CREDIT_CARD(CNumber) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists ROOM_RESERVATION (InvoiceNo int, HotelID int not null, RoomNo int not null, CheckInDate date, CheckOutDate date, constraint room_reservation_pk primary key(HotelID, RoomNo, CheckInDate), constraint room_reservation_room_fk foreign key(HotelID, RoomNo) references ROOM(HotelID, RoomNo) on delete cascade on update cascade, constraint room_reservation_fk foreign key(InvoiceNo) references RESERVATION(InvoiceNo) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}
/*
$sql = "create table if not exists RRESV_BREAKFAST (Btype varchar(16) not null, HotelID int not null, RoomNo int not null, CheckInDate date not null, NoofOrders int, constraint rresv_breakfast_pk primary key(Btype, HotelID, RoomNo, CheckInDate), constraint rresv_breakfast_breakfast_fk foreign key(HotelID, Btype) references BREAKFAST(HotelID, BType) on delete cascade on update cascade, constraint rresv_breakfast_room_reservation_fk foreign key(HotelID, RoomNo, CheckInDate) references BREAKFAST(HotelID, RoomNo, CheckInDate) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}
*/
$sql = "create table if not exists RRESV_SERVICE (Stype varchar(16) not null, HotelID int not null, RoomNo int not null, CheckInDate date not null, constraint rresv_service_pk primary key(Stype, HotelID, RoomNo, CheckInDate), constraint rresv_service_service_fk foreign key(HotelID, Stype) references SERVICE(HotelID, SType) on delete cascade on update cascade, constraint rresv_service_room_reservation_fk foreign key(HotelID, RoomNo, CheckInDate) references ROOM_RESERVATION(HotelID, RoomNo, CheckInDate) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}


$sql = "drop table DISCOUNTED_ROOM cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table RRESV_SERVICE cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RESERVATION drop foreign key reservation_credit_card_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

/*
$sql = "drop table CREDIT_CARD";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}
*/
?>