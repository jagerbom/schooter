<?php

$DEBUG	=	0;
$parent_name		=  $_POST["name"];
$parent_username	=  $_POST["email"];
$parent_password	=  md5($_POST['password']);
$parent_phone_no	=  $_POST["phone_number"];
$parent_num_child	=  $_POST["number_of_children"];

//******* DEBUG PRINTS ********//
if ($DEBUG) {
	echo nl2br("\n parent name is $parent_name");
	echo nl2br("\n parent username is $parent_username");
	echo nl2br("\n parent password is $parent_password");
	echo nl2br("\n parent phone no is $parent_phone_no");
	echo nl2br("\n Number of children is $parent_num_child");
}

//******** Connect to MYSQL database ********//
$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
	if ($DEBUG) {
		echo nl2br("\n Connection to database successfull !!");
	}
}

//******** Create parent_info table into the database ********//
/*if (!($stmt = $mysqli->prepare("create table sch_xaviers_bhopal_parent_info (parent_name varchar(50), parent_username varchar(50) PRIMARY KEY, parent_password varchar(50), parent_phone_no varchar(50), parent_num_child varchar(10))"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} else {
	if ($DEBUG) {
		echo nl2br("\n parent_info table created successfully !!");
	}
}
*/

//******** Create parent_info table into the database ********//
if (!($stmt = $mysqli->prepare("create table sch_parent_info (parent_name varchar(50), parent_id varchar(50) PRIMARY KEY, parent_password varchar(50), parent_phone_no varchar(50))"))) {
	if($DEBUG){
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
}
if (!$stmt->execute()) {
	if($DEBUG){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
} else {
	if ($DEBUG) {
		echo nl2br("\n parent_info table created successfully !!");
	}
}
$sql = "select * from sch_parent_info where parent_id='$parent_username'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
if(!($row)) {
	$sql = "INSERT INTO sch_parent_info (parent_name, parent_id, parent_password, parent_phone_no)
		VALUES ('$parent_name', '$parent_username', '$parent_password', '$parent_phone_no')";
	if ($mysqli->query($sql) === TRUE) {
		if ($DEBUG){
			echo nl2br(" \n New record created successfully");
		}
	} else {
		if($DEBUG){
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
} else {
	echo "parentid is already registered";
}

//******** Insert entries into parent_info table ********//
/*$sql = "INSERT INTO sch_xaviers_bhopal_parent_info (parent_name, parent_username, parent_password, parent_phone_no, parent_num_child)
VALUES ('$parent_name', '$parent_username', '$parent_password', '$parent_phone_no', '$parent_num_child')";
if ($mysqli->query($sql) === TRUE) {
	if ($DEBUG){
		echo nl2br(" \n New record created successfully");
	}
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}*/
//******** Close the connection to database ********//
$mysqli->close();
?>
