<?php
//include constants.php for SITEURL
include('../config/constants.php');

//Destroy the session
session_destroy();
//Redirecting to the login page
header('location:'.SITEURL.'admin/login.php')

?>