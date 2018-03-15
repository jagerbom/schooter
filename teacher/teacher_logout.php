<?php
session_start();
$_SESSION = array();
if(session_destroy())
{
header("Location: /~vaibhav/schooter/teacher/teacher_login.php");
}
?>
