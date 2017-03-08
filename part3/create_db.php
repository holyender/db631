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

$sql = "create table if not exists ROOM_REVIEW (RID int not null, rating int check(rating between 0 and 5), Text varchar(16), CID int, HotelID int, RoomNo int, constraint room_review_pk primary key(RID), constraint room_review_customer_fk foreign key(CID) references CUSTOMER(CID) on delete set null on update cascade, constraint room_review_room_fk foreign key(HotelID, RoomNo) references ROOM(HotelID, RoomNo) on delete set null on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

?>