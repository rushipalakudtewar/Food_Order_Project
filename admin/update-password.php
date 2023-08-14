<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change the password</h1>
        <br><br>

        <?php 
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        ?>
        <form action=""method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current password:</td>
                    <td><input type="password"name="current_password"placeholder="current Password"></td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password"name="new_password"placeholder="New Password"></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password"name="confirm_password"placeholder="Confirm Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password"class="btn-secondary"></td>
                </tr>
            </table>
        </form>
    </div>

</div>
<?php
    //if submit button is checked or not
    if(isset($_POST['submit']))
    {
        //echo "Button clicked";

        //Get the data from Form
         $id=$_POST['id'];
         $current_password=$_POST['current_password'];
         $new_password=$_POST['new_password'];
         $confirm_password=$_POST['confirm_password'];

        //check whether the user id with current id and current password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        
        //execute the query

        $res=mysqli_query($conn,$sql);
        
        if($res==true)
        {
            //echo "query is executed";
           


            if($count==1)
            {
                //if user exists and password has been changed
                //echo "User Found";
                //header('location:'.SITEURL.'admin/update-password.php');

                if($new_password==$confirm_password)
                {
                   $sql2="UPDATE tbl_Admin SET password='$new_password' WHERE id=$id";
                   //execute the query 
                   $res2=mysqli_query($conn,$sql2);
                   //check whether query is executed or not
                   if($res2==true)
                   {
                       $_SESSION['change-pwd']="<div class='success'>password changed successfully.</div>";
                       header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //display error message
                        $_SESSION['change-pwd']="<div class='error'>password is not changed</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    $_SESSION['pwd-not-found']="<div class='error'>Password didn't match</div>";
                    //redirect to the page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //User does'nt exists and set message and redirect to the manage-admin page
                $_SESSION['user-not-found']="<div class='error'>User not found.</div>";
                //rediecting to the manage-admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        
        
        //check whether the New password and confirm password is match or not
        //change password is all above is true

    }
    
?>

<?php include('partials/footer.php'); ?>