<?php

include("config.php");

$sql = "create table if not exists CUSTOMER (CID int not null auto_increment, Name varchar(16) default null, Address varchar(64) default null, Phone_no char(10) default null, Email varchar(16) default null, constraint customer_pk primary key(CID))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists CREDIT_CARD (CNumber int not null, Ctype varchar(8) not null, Baddress varchar(16) not null, Code char(3) not null, ExpDate date not null, Name varchar(16) not null, constraint credit_card_pk primary key(CNumber))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists HOTEL (HotelID int not null, Street varchar(32) default null, Country varchar(16) default null, State varchar(16) default null, Zip char(5) default null, constraint hotel_pk primary key(HotelID))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists ROOM (HotelID int not null, RoomNo int not null, Rtype varchar(16) default null, Price decimal(5,2) default null, Description text, Floor int not null, Capacity int default null, constraint room_pk primary key(HotelID, RoomNo), constraint room_hotel_fk foreign key(HotelID) references HOTEL(HotelID) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists DISCOUNTED_ROOM (HotelID int not null, RoomNo int not null, Discount decimal(5,2) default null, StartDate date default null, EndDate date default null, constraint discounted_room_pk primary key(HotelID, RoomNo), constraint discounted_room_room_fk foreign key(HotelID, RoomNo) references ROOM(HotelID, RoomNo) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists SERVICE (HotelID int not null, SType varchar(16) not null, SPrice decimal(5,2) default null, constraint service_pk primary key(HotelID, SType), constraint service_hotel_fk foreign key(HotelID) references HOTEL(HotelID) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists BREAKFAST (HotelID int not null, BType varchar(16) not null, BPrice decimal(5,2) default null, Description text, constraint breakfast_pk primary key(HotelID, BType), constraint breakfast_hotel_fk foreign key(HotelID) references HOTEL(HotelID) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists ROOM_REVIEW (RID int not null, Rating int default null check(rating between 0 and 5), Text text, CID int default null, HotelID int not null, RoomNo int not null, constraint room_review_pk primary key(RID), constraint room_review_customer_fk foreign key(CID) references CUSTOMER(CID) on delete set null on update cascade, constraint room_review_room_fk foreign key(HotelID, RoomNo) references ROOM(HotelID, RoomNo) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists BREAKFAST_REVIEW (RID int not null, HotelID int not null, BType varchar(16) not null, CID int default null, Text text, Rating int default null check(Rating between 0 and 5), constraint breakfast_review_pk primary key(RID), constraint breakfast_review_breakfast_fk foreign key(HotelID, BType) references BREAKFAST(HotelID, BType) on delete cascade on update cascade, constraint breakfast_review_customer_fk foreign key(CID) references CUSTOMER(CID) on delete set null on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists SERVICE_REVIEW (RID int not null, HotelID int not null, SType varchar(16) not null, CID int default null, Rating int default null check(Rating between 0 and 5), Text text, constraint service_review_pk primary key(RID), constraint service_review_service_fk foreign key(HotelID, SType) references SERVICE(HotelID, SType) on delete cascade on update cascade, constraint service_review_customer_fk foreign key(CID) references CUSTOMER(CID) on delete set null on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists RESERVATION (InvoiceNo int not null, CID int not null, Cnumber int not null, Rdate date default null, constraint reservation_pk primary key(InvoiceNo), constraint reservation_customer_fk foreign key(CID) references CUSTOMER(CID) on delete cascade on update cascade, constraint reservation_credit_card_fk foreign key(Cnumber) references CREDIT_CARD(CNumber) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists ROOM_RESERVATION (InvoiceNo int not null, HotelID int not null, RoomNo int not null, CheckInDate date not null, CheckOutDate date not null, constraint room_reservation_pk primary key(HotelID, RoomNo, CheckInDate), constraint room_reservation_room_fk foreign key(HotelID, RoomNo) references ROOM(HotelID, RoomNo) on delete cascade on update cascade, constraint room_reservation_reservation_fk foreign key(InvoiceNo) references RESERVATION(InvoiceNo) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists RRESV_BREAKFAST (Btype varchar(16) not null, HotelID int not null, RoomNo int not null, CheckInDate date not null, NoofOrders int default null, constraint rresv_breakfast_pk primary key(Btype, HotelID, RoomNo, CheckInDate), constraint rresv_breakfast_breakfast_fk foreign key(HotelID, Btype) references BREAKFAST(HotelID, BType) on delete cascade on update cascade, constraint rresv_breakfast_room_reservation_fk foreign key(HotelID, RoomNo, CheckInDate) references ROOM_RESERVATION(HotelID, RoomNo, CheckInDate) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists RRESV_SERVICE (Stype varchar(16) not null, HotelID int not null, RoomNo int not null, CheckInDate date not null, constraint rresv_service_pk primary key(Stype, HotelID, RoomNo, CheckInDate), constraint rresv_service_service_fk foreign key(HotelID, Stype) references SERVICE(HotelID, SType) on delete cascade on update cascade, constraint rresv_service_room_reservation_fk foreign key(HotelID, RoomNo, CheckInDate) references ROOM_RESERVATION(HotelID, RoomNo, CheckInDate) on delete cascade on update cascade)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "create table if not exists HOTEL_PHONES (HotelID int not null, PhoneNo char(10) not null, constraint hotel_phone_pk primary key(HotelID, PhoneNo), constraint hotel_phones_fk foreign key(HotelID) references HOTEL(HotelID))";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

/*
//////////////////////
// to remove all tables for debugging
//////////////////////

// drop all foreign keys
// BREAKFAST
// BREAKFAST_REVIEW
// CREDIT_CARD
// CUSTOMER
// DISCOUNTED_ROOM
// HOTEL
// RESERVATION
// ROOM
// ROOM_RESERVATION
// ROOM_REVIEW
// RRESV_BREAKFAST
// RRESV_SERVICE
// SERVICE
// SERVICE_REVIEW

$sql = "alter table BREAKFAST drop foreign key breakfast_hotel_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table BREAKFAST_REVIEW drop foreign key breakfast_review_breakfast_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table BREAKFAST_REVIEW drop foreign key breakfast_review_customer_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table BREAKFAST_REVIEW drop index breakfast_review_customer_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table BREAKFAST_REVIEW drop index breakfast_review_breakfast_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// no foreign key for CREDIT_CARD

// no foreign key for CUSTOMER

$sql = "alter table DISCOUNTED_ROOM drop foreign key discounted_room_room_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// no foreign key for HOTEL

$sql = "alter table RESERVATION drop foreign key reservation_customer_fk";

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

$sql = "alter table ROOM drop foreign key room_hotel_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_RESERVATION drop foreign key room_reservation_reservation_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_RESERVATION drop foreign key room_reservation_room_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_REVIEW drop foreign key room_review_room_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_REVIEW drop foreign key room_review_customer_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_REVIEW drop index room_review_customer_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_REVIEW drop index room_review_room_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_BREAKFAST drop foreign key rresv_breakfast_breakfast_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_BREAKFAST drop index rresv_breakfast_breakfast_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_BREAKFAST drop foreign key rresv_breakfast_room_reservation_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_BREAKFAST drop index rresv_breakfast_room_reservation_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_SERVICE drop foreign key rresv_service_service_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_SERVICE drop foreign key rresv_service_room_reservation_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table SERVICE drop foreign key service_hotel_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table SERVICE_REVIEW drop foreign key service_review_service_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table SERVICE_REVIEW drop index service_review_service_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = " alter table SERVICE_REVIEW drop foreign key service_review_customer_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table SERVICE_REVIEW drop index service_review_customer_fk";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// end of droping all foreign keys

// end of dropping all unique

// drop all primary keys
// BREAKFAST
// BREAKFAST_REIVEW
// CREDIT_CARD
// CUSTOMER
// DISCOUNTED_ROOM
// HOTEL
// RESERVATION
// ROOM
// ROOM_RESERVATION
// ROOM_REVIEW
// RRESV_BREAKFAST
// RRESV_SERVICE
// SERVICE
// SERVICE_REVIEW

$sql = "alter table BREAKFAST drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table BREAKFAST_REVIEW drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table CREDIT_CARD drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table CUSTOMER drop primary key, change CID CID int";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table DISCOUNTED_ROOM drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table HOTEL drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RESERVATION drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_RESERVATION drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table ROOM_REVIEW drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_BREAKFAST drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table RRESV_SERVICE drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table SERVICE drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "alter table SERVICE_REVIEW drop primary key";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// drop all tables
// BREAKFAST
// BREAKFAST_REVIEW
// CREDIT_CARD
// CUSTOMER
// DISCOUNTED_ROOM
// HOTEL
// RESERVATION
// ROOM
// ROOM_RESERVATION
// ROOM_REVIEW
// RRESV_BREAKFAST
// RRESV_SERVICE
// SERVICE
// SERVICE_REVIEW

$sql = "drop table if exists BREAKFAST cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists BREAKFAST_REVIEW cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists CREDIT_CARD cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists CUSTOMER cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists DISCOUNTED_ROOM cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists HOTEL cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists RESERVATION cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists ROOM cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists ROOM_RESERVATION cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists ROOM_REVIEW cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists RRESV_BREAKFAST cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists RRESV_SERVICE cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists SERVICE cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "drop table if exists SERVICE_REVIEW cascade";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

// end of removing all tables for debugging
*/

/*
// insert dummy data

//////////////////////
// insert dummy CUSTOMER
//////////////////////

$sql = "insert into CUSTOMER (CID, Name, Address, Phone_no, Email) values (1, 'John Losito', '323 Dr Martin Luther King Jr Blvd, Newark, NJ 07102
', '1234567890', 'jjl37@njit.edu')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

//////////////////////
// insert dummy HOTEL
//////////////////////

$sql = "insert into HOTEL (HotelID, Street, Country, State, Zip) values (1, 'S Dr Martin Luther King', 'USA', 'NJ', '08401')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into HOTEL (HotelID, Street, Country, State, Zip) values (2, '777 Harrah\'s Blvd', 'USA', 'NJ', '08401')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into HOTEL (HotelID, Street, Country, State, Zip) values (3, '1 Borgata Way', 'USA', 'NJ', '08401')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 1, 'Suite', 82.00, 'Crowne Plaza, guests enjoy a two-room suite perfectly equipped for comfort and convenience. You’ll feel relaxed and taken care of whether you’re here for an extended stay or just a night. With a private bedroom and separate living room with a sleeper-sofa, you\'ve got plenty of room for family, work or both. A flat screen TV in each room with cable and in-suite movies means that everyone can watch what they like. Other amenities include wet bar, refrigerator, microwave and Wi-Fi.® You’ll also have a coffeemaker, iron with board and hair dryer for added convenience. So make yourself right at home.', 1, 2)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 2, 'Suite', 82.00, 'Crowne Plaza, guests enjoy a two-room suite perfectly equipped for comfort and convenience. You’ll feel relaxed and taken care of whether you’re here for an extended stay or just a night. With a private bedroom and separate living room with a sleeper-sofa, you\'ve got plenty of room for family, work or both. A flat screen TV in each room with cable and in-suite movies means that everyone can watch what they like. Other amenities include wet bar, refrigerator, microwave and Wi-Fi.® You’ll also have a coffeemaker, iron with board and hair dryer for added convenience. So make yourself right at home.', 1, 2)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 3, 'Deluxe', 141.00, 'A stylish retreat for starlets and Oscar hopefuls, our Queen Deluxe hotel room features 176-208 sq. ft. of expertly appointed accommodations and is smartly equipped with a queen-sized bed and all our luxurious amenities to create an intimate, elegant hideaway.', 2, 4)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 4, 'Deluxe', 141.00, 'A stylish retreat for starlets and Oscar hopefuls, our Queen Deluxe hotel room features 176-208 sq. ft. of expertly appointed accommodations and is smartly equipped with a queen-sized bed and all our luxurious amenities to create an intimate, elegant hideaway.', 2, 4)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 5, 'Premium', 162.00, 'Our King Premium hotel room, offering deLuxe amenities, provides 199 – 239 sq ft of well-appointed space. A king-sized bed provides the perfect resting space for a tired starlet.', 1, 3)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 6, 'Suite', 82.00, 'Crowne Plaza, guests enjoy a two-room suite perfectly equipped for comfort and convenience. You’ll feel relaxed and taken care of whether you’re here for an extended stay or just a night. With a private bedroom and separate living room with a sleeper-sofa, you\'ve got plenty of room for family, work or both. A flat screen TV in each room with cable and in-suite movies means that everyone can watch what they like. Other amenities include wet bar, refrigerator, microwave and Wi-Fi.® You’ll also have a coffeemaker, iron with board and hair dryer for added convenience. So make yourself right at home.', 1, 2)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 7, 'Suite', 82.00, 'Crowne Plaza, guests enjoy a two-room suite perfectly equipped for comfort and convenience. You’ll feel relaxed and taken care of whether you’re here for an extended stay or just a night. With a private bedroom and separate living room with a sleeper-sofa, you\'ve got plenty of room for family, work or both. A flat screen TV in each room with cable and in-suite movies means that everyone can watch what they like. Other amenities include wet bar, refrigerator, microwave and Wi-Fi.® You’ll also have a coffeemaker, iron with board and hair dryer for added convenience. So make yourself right at home.', 2, 2)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 8, 'Deluxe', 141.00, 'A stylish retreat for starlets and Oscar hopefuls, our Queen Deluxe hotel room features 176-208 sq. ft. of expertly appointed accommodations and is smartly equipped with a queen-sized bed and all our luxurious amenities to create an intimate, elegant hideaway.', 2, 4)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into ROOM (HotelID, RoomNo, Rtype, Price, Description, Floor, Capacity) values (1, 8, 'Deluxe', 141.00, 'A stylish retreat for starlets and Oscar hopefuls, our Queen Deluxe hotel room features 176-208 sq. ft. of expertly appointed accommodations and is smartly equipped with a queen-sized bed and all our luxurious amenities to create an intimate, elegant hideaway.', 2, 4)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into SERVICE (HotelID, SType, SPrice) values (1, 'Parking', 25.00)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into SERVICE (HotelID, SType, SPrice) values (1, 'Laundry', 10.00)";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into DISCOUNTED_ROOM (HotelID, RoomNo, Discount, StartDate, EndDate) values (1, 1, 15.00, '2017-03-13', '2017-03-24')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}

$sql = "insert into BREAKFAST (HotelID, BType, BPrice, Description) values (1, 'English', 10.00, 'Traditional full English breakfast includes bacon traditionally back bacon ried, poached or scrambled eggs, fried or grilled tomatoes, fried mushrooms, fried bread or toast with butter, and sausages.')";

$result = mysqli_query($conn, $sql);
if(!$result){
  echo "query error: " . mysqli_error($conn);
  exit;
}
*/
?>