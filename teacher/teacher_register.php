<?php

$DEBUG	=	1;
$teacher_name		=  $_POST["teacher_name"];
$teacher_id		=  $_POST["teacher_id"];
$teacher_password	=  md5($_POST["teacher_password"]);
$teacher_age		=  $_POST["teacher_age"];
$teacher_sex		=  $_POST["teacher_sex"];
$teacher_phone_no	=  $_POST["teacher_phone_no"];
$teacher_post		=  $_POST["teacher_post"];
$teacher_class_teacher_class		=  $_POST["class_teacher_class"];
$teacher_class_teacher_section		=  $_POST["class_teacher_section"];
$teacher_class_teacher_subject		=  $_POST["class_teacher_subject"];
$teacher_class_two_class		=  $_POST["class_two"];
$teacher_class_two_section		=  $_POST["class_two_section"];
$teacher_class_two_subject		=  $_POST["class_two_subject"];
$teacher_class_three_class		=  $_POST["class_three"];
$teacher_class_three_section		=  $_POST["class_three_section"];
$teacher_class_three_subject		=  $_POST["class_three_subject"];
$teacher_class_four_class		=  $_POST["class_four"];
$teacher_class_four_section		=  $_POST["class_four_section"];
$teacher_class_four_subject		=  $_POST["class_four_subject"];
$teacher_class_five_class		=  $_POST["class_five"];
$teacher_class_five_section		=  $_POST["class_five_section"];
$teacher_class_five_subject		=  $_POST["class_five_subject"];

//******* DEBUG PRINTS ********//
if ($DEBUG) {
	echo $_POST["class_teacher_class"];
	echo nl2br("\n teacher name is $teacher_name");
	echo nl2br("\n teacher id is   $teacher_id");
	echo nl2br("\n teacher password is   $teacher_password");
	echo nl2br("\n teacher age is $teacher_age");
	echo nl2br("\n teacher sex is $teacher_sex");
	echo nl2br("\n teacher phoneno is $teacher_phone_no");
	echo nl2br("\n teacher post is $teacher_post");
	echo nl2br("\n class teacher class is $teacher_class_teacher_class");
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

function insert_into_teacher_class_info($mysqli, $teacher_id, $class, $section, $subject, $class_teacher) {
	if (!($class || $section || $subject)) {
		echo "SOME THING IS FISHY" . "<br>";
		return 0;
	}
	$sql = "INSERT INTO sch_xaviers_bhopal_teacher_class_info (teacher_id, class, section, subject, class_teacher)
		VALUES ('$teacher_id', '$class', '$section', '$subject', '$class_teacher')";
	if ($mysqli->query($sql) === TRUE) {
		echo nl2br(" \n New record created successfully");
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

if (!($stmt = $mysqli->prepare("create table sch_xaviers_bhopal_teacher_info (teacher_name varchar(50), teacher_id varchar(50) PRIMARY KEY, teacher_password varchar(50), teacher_age varchar(10), teacher_sex varchar(10), teacher_phoneno varchar(20), teacher_post varchar(100))"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error . "<br>";
} else {
	if ($DEBUG) {
		echo nl2br("\n teacher_info table created successfully !!");
	}
}

if ($teacher_id) {
	$sql = "INSERT INTO sch_xaviers_bhopal_teacher_info (teacher_name, teacher_id, teacher_password, teacher_age, teacher_sex, teacher_phoneno, teacher_post)
		VALUES ('$teacher_name', '$teacher_id', '$teacher_password', '$teacher_age', '$teacher_sex', '$teacher_phoneno', '$teacher_post')";
	if ($mysqli->query($sql) === TRUE) {
		echo nl2br(" \n New record created successfully");
		if (!($stmt = $mysqli->prepare("create table sch_xaviers_bhopal_teacher_class_info (teacher_id varchar(50), class varchar(10), section varchar(10), subject varchar(10), class_teacher varchar(10))"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error . "<br>";
		} else {
			if ($DEBUG) {
				echo nl2br("\n teacher_info table created successfully !!");
			}
		}
		insert_into_teacher_class_info($mysqli, $teacher_id, $teacher_class_teacher_class, $teacher_class_teacher_section, $teacher_class_teacher_subject, yes);
		insert_into_teacher_class_info($mysqli, $teacher_id, $teacher_class_two_class, $teacher_class_two_section, $teacher_class_two_subject, no);
		insert_into_teacher_class_info($mysqli, $teacher_id, $teacher_class_three_class, $teacher_class_three_section, $teacher_class_three_subject, no);
		insert_into_teacher_class_info($mysqli, $teacher_id, $teacher_class_four_class, $teacher_class_four_section, $teacher_class_four_subject, no);
		insert_into_teacher_class_info($mysqli, $teacher_id, $teacher_class_five_class, $teacher_class_five_section, $teacher_class_five_subject, no);

	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
$mysqli->close();
?>
