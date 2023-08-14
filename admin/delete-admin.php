<?php
//go the $con for connecting the database(include constants.php file is here)
include('../config/constants.php');
//Get the ID to be deleted 
$id=$_GET['id'];
//write the query to delete the admin
$sql="DELETE FROM tbl_admin WHERE id=$id";
$res=mysqli_query($conn,$sql);
//recheck whether the query is executed or not 
if($res==TRUE)
{
    //query is successfully executed
    //echo "admin is successfully deleted";
    //create session variable to display the message
    $_SESSION['delete']="<div class='success'>Deleted successfully.</div>";
    //refreshing the manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    //query is not successfully executed
    //echo "admin is not deleted";
    $_SESSION['delete']="<div class='error'>Failed to delete the admintry again later.</div>";
    //refreshing the manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
        

}



?>