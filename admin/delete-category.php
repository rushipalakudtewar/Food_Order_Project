
<?php include('../config/constants.php');

//Get the id form database
//$id=$_GET['id'];
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //Get the value and delete
    //echo "Get the value and delete";
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    //Remove the physical image file is avaliable
    if($image_name!='')
    {
        //so imag is available to remove it
        $path=('../images/category/').$image_name;
        //remove the image
        $remove=unlink($path);
        //if failed to remove the image then add an error message and stop the process
        if($remove==false)
        {
            //set the session message
             $_SESSION['remove']="<div class='error'>Failed to remove the category image</div>";
            //and redirect to the manage-category page
            header('location:'.SITEURL.'admin/manage-category.php');

             //stop the process
             die();
        }
    }


    $sql="DELETE FROM tbl_category WHERE id=$id";


    $res=mysqli_query($conn,$sql);
    
    
    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Category successfully deleted.</div>";
        //display the message on manage-category page
        header('location:'.SITEURL.'admin/manage-category.php');
    
    }
    else
    {
        $_SESSION['delete']="<div class='error'>Category is not deleted.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
}
else
{
    //redirect to manage catagory page
    header('location:'.SITEURL.'admin/manage-category.php');
}
/*

*/
?>