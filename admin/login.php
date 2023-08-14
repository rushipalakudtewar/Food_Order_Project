<?php include('../config/constants.php'); ?>

<html>
<head>
<title>login-Food-order system</title>
<link rel="stylesheet"href="../css/admin.css">
</head>
<body>
    <div class="login bg">
    <h1 class="text-center">Login</h1>
<br>
    <?php
    if(isset($_SESSION['login']))
    {
        echo $_SESSION['login'];
        unset($_SESSION['login']);

    }
    if(isset($_SESSION['no-login-message']))
    {
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    }
 ?>
 <br>
    <form action=""method="POST"class="Text-center">
    <br>
    Username:
    <input type="text"name="username"placeholder="Enter the username"><br><br>
    Password:
    <input type="password"name="password"placeholder="Enter the password"><br>
    <input type="submit"name="submit"value="login"class="btn-primary">
    <br><br>
    </form>
    <p class="text-center">Created by-<a href="www.rushipalakudtewar.com">Rushi palakudtewar</a></p></div>
    
</body>
</html>
<?php
//check whether submit button clicked or not
if(isset($_POST['submit']))
{
    //process to login
    //1 get the data from login form
    echo $username=$_POST['username'];
    echo $password=$_POST['password'];

    //2 sql to  check whether the user with username and password exists or not
    $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    $res=mysqli_query($conn,$sql);

    $count=mysqli_num_rows($res);

    if($count==1)
    {
        //user available
        $_SESSION['login']="<div class='success'>Login successful.</div>";
        $_SESSION['user']=$username;// To check whether the user is logged in or not
        header('location:'.SITEURL.'admin/');
    }
    else{
        //user not available
        $_SESSION['login']="<div class='error text-center'>Incorrect user and password</div>";
        header('location:'.SITEURL.'admin/login.php');
    
    }
}
?>