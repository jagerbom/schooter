<?php
ob_start();
session_start();

if(isset( $_SESSION['user_id'] )) {
echo nl2br(" \n user is already logged in");
}

$username	=	$_POST["email"];
$password	=	$_POST["password"];
$password_proctected	=	md5($_POST["password"]);
echo nl2br("\n username = $username and password = $password");
if (!($username && $password)){
	$err = 'one of more feilds are empty';
	echo $err;
	return $err;
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

/*$sql = "select * from sch_xaviers_bhopal_parent_info where parent_username='$username' and parent_password='$password_proctected'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$cur_status = $row['parent_name'];
*/
$sql = "select * from sch_parent_info where parent_id='$username' and parent_password='$password_proctected'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$cur_status = $row['parent_name'];

if($cur_status) {
	echo nl2br("\n authentication successfull!!! Welcome Mr.  $cur_status \n your child details are \n");
	$sql = "select * from sch_child_info where student_parent_id='$username'";
	$result = $mysqli->query($sql);
	$row = mysqli_fetch_all($result,MYSQLI_ASSOC);
	//print_r($row);
	for($x=0; $x<5; $x++) {
		if(!$row[$x]['student_name']){
			break;
		}
		$student_name = $row[$x]['student_name'];
		$student_school = $row[$x]['school_id'];
		//echo nl2br("\n student_name = $student_name, student_id = $student_id");
		echo nl2br("\n Name: $student_name
		School id: $student_school \n");
	}
	session_regenerate_id();
	$_SESSION['user_id'] = $username;
	session_write_close();
	//header("location: /~vaibhav/schooter/parent/parent_login_success.php");
	exit();
}

/*if (!$cur_status) {
	$msg = "Authentication Failure !!!! Please provide correct credentials.";
	$_SESSION['msg'] = $msg;
	header("location: /~vaibhav/schooter/parent/parent_login.php");
} else {
	$sql = "select * from sch_xaviers_bhopal_student_info where student_parent_id='$username'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$student_name = $row['student_name'];
	$student_class   = $row['student_class'];	
	$student_section  = $row['student_section'];	
	$student_age   = $row['student_age'];	
	$student_sex   = $row['student_sex'];	
	//echo nl2br("\n student_name = $student_name, student_id = $student_id");
	echo nl2br("\n authentication successfull!!! Welcome Mr.  $cur_status \n\n\n your child details are 
		Name: $student_name
		Class: $student_class
		Section: $student_section
		Age: $student_age
		Sex: $student_sex");
	session_regenerate_id();
	$_SESSION['user_id'] = $username;
	session_write_close();
	header("location: /~vaibhav/schooter/parent/parent_login_success.php");
	exit();
}
*/
?>
