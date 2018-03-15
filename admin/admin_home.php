<?php
ob_start();
session_start();
$admin_id = $_SESSION['admin_user_id'];
if(!$admin_id) {
        echo ("You are not logged in, please go to login page and provide credentials");
        return 0;
}
echo nl2br("\n <h4 align=\"right\">  click here to <a href=\"/~vaibhav/schooter/admin/admin_logout.php\">LogOut</a> </h4>");

?>

<html>
<body bgcolor="#E6E6FA">

<h1 align="center"><font color="red">Welcome to Schooter. Drive your child to successfull career </h1>
<h2><a href="/~vaibhav/schooter/teacher/teacher_register_html.php/">Register a teacher</a></h2>
<h2><a href="/~vaibhav/schooter/parent/parent_register_html.php/">Register a parent</a></h2>
<h2><a href="/~vaibhav/schooter/student/student_register_html.php/">Register a student</a></h2>
</body>
</html>
