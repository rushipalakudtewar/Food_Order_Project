<?php include('../config/constants.php');


if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //echo "got id";
    //1.get the values and delete
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];
    //2.Remove the physical image file is avaliable
    if($image_name!='')
    {
        //so image is avaliable
        $path=('../images/food/').$image_name;
        $remove=unlink($path);
        if($remove==false)
        {
            $_SESSION['remove']="<div class='error'>Failed to remove the image</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            die();
        }

    }

    //3.Add the query
    $sql="DELETE FROM tbl_food WHERE id=$id";

    $res=mysqli_query($conn,$sql);

    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Food deleted successfully</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {    
        $_SESSION['delete']="<div class='error'>Failed to delete the food</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
}
else
{
    //echo "not got id"; 
    //$_SESSION['delete']="<div class='error'>Unauthorized access</div>";
    //redirecting to the manage-food page
    header('location:'.SITEURL.'admin/manage-food.php');
}


?>