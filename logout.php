<?php
// this file is used to log out by destorying the sessiion the user and redirect them to the login page
session_start();
session_destroy();
header("Location: Login.php");
?>