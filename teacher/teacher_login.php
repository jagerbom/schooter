<?php
session_start();
if(isset( $_SESSION['msg'] )) {
	echo ($_SESSION['msg']);
	unset($_SESSION['msg']);
}
if(isset( $_SESSION['teacher_user_id'] )) {
	echo ($_SESSION['teacher_user_id']);
	echo nl2br(" is already logged in");
}
?>

<html>
<body bgcolor="#E6E6FA">
<h1 align="center"> <font color="red">Welcome to Schooter. Drive your child to successfull career </h1>
<h4 align="center">  click here to goto <a href="/~vaibhav/schooter/schooter_home.php">Home</a> </h4>
<h2> Login as teacher </h2>

<form action="/~vaibhav/schooter/teacher/teacher_login_authenticate.php" method="post">
  Username: <input type="text" name="email"><br>
  Password: <input type="text" name="password"><br>
  <input type="submit" value="Login">
</form>


</body>
</html>
