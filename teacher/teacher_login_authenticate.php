<?php
ob_start();
session_start();

if(isset( $_SESSION['teacher_user_id'] )) {
echo nl2br(" \n user is already logged in");
}

$username	=	$_POST["email"];
$password	=	$_POST["password"];
$password_proctected	=	md5($_POST["password"]);
$err;
if (!($username || $password)){
	$err = 'one of more feilds are empty';
	echo $err;
	return $err;
}

$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
        if ($DEBUG) {
                echo nl2br("\n Connection to database successfull !!");
        }   
}

$sql = "select * from sch_xaviers_bhopal_teacher_info where teacher_id='$username' and teacher_password='$password_proctected'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$teacher_id = $row['teacher_id'];

if (!$teacher_id) {
	$msg = "Authentication Failure !!!! Please provide correct credentials.";
	$_SESSION['msg'] = $msg;
	header("location: /~vaibhav/schooter/teacher/teacher_login.php");
} else {
	echo nl2br("\n authentication successfull!!! Welcome $teacher_id "); 
	session_regenerate_id();
	$_SESSION['teacher_user_id'] = $username;
	session_write_close();
	header("location: /~vaibhav/schooter/teacher/teacher_login_success.php");
	exit();
}

?>
