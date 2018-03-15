<?php

$DEBUG	=	1;
$student_name		=  $_POST["name"];
$student_id		=  $_POST["student_id"];
$student_parent_id	=  $_POST["parent_id"];
$student_class		=  $_POST["class"];
$student_section	=  $_POST["section"];
$student_age		=  $_POST["student_age"];
$student_sex		=  $_POST["student_sex"];
$school_id		=  $_POST["school_id"];

//******* DEBUG PRINTS ********//
if ($DEBUG) {
	echo nl2br("\n student name is $student_name");
	echo nl2br("\n student id is   $student_id");
	echo nl2br("\n student parent is $student_parent_id");
	echo nl2br("\n student class is $student_class");
	echo nl2br("\n student section is $student_section");
	echo nl2br("\n student age is $student_age");
	echo nl2br("\n student sex is $student_sex");
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

if (!($stmt = $mysqli->prepare("create table sch_child_info (student_name varchar(50), student_id varchar(50) PRIMARY KEY, student_parent_id varchar(50), school_id varchar(50))"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error . "<br>";
} else {
	if ($DEBUG) {
		echo nl2br("\n sch_child_info created successfully !!");
	}
}

$sql = "INSERT INTO sch_child_info (student_name, student_id, student_parent_id, school_id)
VALUES ('$student_name', '$student_id', '$student_parent_id', '$school_id')";
if ($mysqli->query($sql) === TRUE) {
	if ($DEBUG){
		echo nl2br(" \n New record created successfully");
	}
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

//******** Create parent_info table into the database ********//
/*if (!($stmt = $mysqli->prepare("create table sch_xaviers_bhopal_student_info (student_name varchar(50), student_id varchar(50) PRIMARY KEY, student_parent_id varchar(50), student_class varchar(50), student_section varchar(10), student_age varchar(10), student_sex varchar(10))"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error . "<br>";
} else {
	if ($DEBUG) {
		echo nl2br("\n parent_info table created successfully !!");
	}
}
*/
//******** Insert entries into parent_info table ********//
/*$sql = "INSERT INTO sch_xaviers_bhopal_student_info (student_name, student_id, student_parent_id, student_class, student_section, student_age, student_sex)
VALUES ('$student_name', '$student_id', '$student_parent_id', '$student_class', '$student_section', '$student_age', '$student_sex')";
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
