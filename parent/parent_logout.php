<?php
session_start();
$_SESSION = array();
if(session_destroy())
{
header("Location: /~vaibhav/schooter/parent/parent_login.php");
}
?>
