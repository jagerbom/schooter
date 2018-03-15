<?php
session_start();
$_SESSION = array();
if(session_destroy())
{
header("Location: /~vaibhav/schooter/admin/admin_login.php");
}
?>
