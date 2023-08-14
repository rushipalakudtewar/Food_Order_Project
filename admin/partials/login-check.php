<?php
        //Authorization . Access control
        //check whether user logged in or not
    if(!isset($_SESSION['user']))//user session is not set
    {

        //user is not logged in 
        //redirec to loogin page with message
        $_SESSION['no-login-message']="<div class='error text-center'>Please login to access Admin panel.</div>";
        //redirect to login page
        header('location:'.SITEURL.'admin/login.php');
    }


?>