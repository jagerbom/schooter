<?php
ob_start();
session_start();

if(isset( $_SESSION['admin_user_id'] )) {
echo nl2br(" \n user is already logged in");
}

$username	=	$_POST["email"];
$password	=	$_POST["password"];
$err;
if (!($username || $password)){
	$err = 'one of more feilds are empty';
	echo $err;
	return $err;
}
//echo nl2br("\n username = $username and password = $password");

//******** Connect to MYSQL database ********//
$mysqli = new mysqli("127.0.0.1", "root", "", "schooter_final");
if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
        if ($DEBUG) {
                echo nl2br("\n Connection to database successfull !!");
        }   
}

$sql = "select * from sch_xaviers_bhopal_admin_info where userid='$username' and password='$password'";
echo "$sql";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$cur_status = $row['userid'];

if (!$cur_status) {
	$msg = "Authentication Failure !!!! Please provide correct credentials.";
	$_SESSION['msg'] = $msg;
	header("location: /~vaibhav/schooter/admin/admin_login.php");
} else {
	echo nl2br("\n authentication successfull!!! Welcome Admin");
	session_regenerate_id();
	$_SESSION['admin_user_id'] = $username;
	session_write_close();
	header("location: /~vaibhav/schooter/admin/admin_home.php");
	exit();
}

?>
