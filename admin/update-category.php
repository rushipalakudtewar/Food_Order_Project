<?php
include ('partials/menu.php');
?>
<div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>

        <br><br>
        
        <?php
        //check whether id is set or not
        if(isset($_GET['id']))
        {
            //Get the id and all other details
            //echo "Data is displayed";
            $id=$_GET['id'];
            //Create sql query to get the all the details
            $sql="SELECT * FROM tbl_category WHERE id=$id";
            //execute the query
            $res=mysqli_query($conn,$sql);
            //Count the rows to check whether id is valid or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //Get the data
                $row=mysqli_fetch_assoc($res);
                $title=$row['title'];
                $current_image=$row['image_name'];
                $featured=$row['featured'];
                $active=$row['active'];
            }
            else
            {
                $_SESSION['No-category-found']="<div class='error'>No category found</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }
        else
        {   
            //Redirect to the manage-category page
            header('location:'.SITEURL.'/admin/manage-category.php');
        }
        ?>



        <form action=""method="POST"enctype="multipart/form-data">
            <table class='tbl-30'>
                <tr>
                    <td>Title:</td>
                    <td><input type="text"name="title"value="<?php echo $title?>"></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td><?php
                        if($current_image!="")
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>"width=150px >
                            <?php
                        }
                        else{
                            
                           echo "<div class='error'>Image Not Added.</div>";
                           
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td><input type="file"name="image"></td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td><input <?php if($featured=="Yes") {echo "checked"; }?> type="radio"name="featured"value=Yes>Yes
                    <input <?php if($featured=="No") {echo "checked";}?> type="radio"name="featured"value=No>No</td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td><input <?php if($featured=="Yes") {echo "checked"; }?> type="radio"name="active"value=Yes>Yes
                    <input <?php if($featured=="No") {echo "checked"; }?> type="radio"name="active"value=No>No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden"name="current_image"value="<?php echo $current_image; ?>">
                        <input type="hidden"name="id"value="<?php echo $id; ?>">
                        <input type="submit"name="submit"value="Update Category"class="btn-secondary"></td>
                </tr>
            </table>


        </form>
        <?php
        if(isset($_POST['submit']))
        {   
            //step1:Get the data from the Form
           $id=$_POST['id'];
           $title=$_POST['title'];
           $current_image=$_POST['current_image'];
           $featured=$_POST['featured'];
           $active=$_POST['active'];
            
            //step2:Updating new image and select
            //check whether image is selected or not
            if(isset($_FILES['image']['name']))
            {
                //Get the image details 
                $image_name=$_FILES['image']['name'];
                //check whether the image selected or not
                if($image_name!="")
                {
                    //image is avalible
                    //upload the new image
                    //A.Auto rename our Image
                    //get the extension of our image (jpg,png,gif,etc)eg."food1.jpg"
                    $ext=end(explode('.',$image_name));

                    //Rename the image
                    $image_name="Food__".rand(000,999).'.'.$ext; //after renaming the img ex.has shown Food_Category_324.jpg
    
                    $src=$_FILES['image']['tmp_name'];
    
                    $destination_path="../images/category/".$image_name;
    
                    //Finally upload the image
                    $upload=move_uploaded_file($src,$destination_path);
    
    
                    //check whether the image is uploaded or not uploaded
                    //if the image is not uploaded then we will stop the process and redirect to the error message
                    if($upload==false)
                    {
                        $_SESSION['upload']="<div class='error'>Failed to upload the image</div>";
                        //Redirect to add category page
                        header('location:'.SITEURL.'admin/manage-category.php');
                        //Stop the process
                        die();
                    }
                    //B.remove the current image
                    if($current_image!="")
                    {
                    $remove_path="../images/category/".$current_image;
                    $remove=unlink($remove_path);
                    //check whether image is removed or not
                    //if failed the current image and display the message
                        if($remove==false)
                        {
                            $_SESSION['failed-remove']="<div class='error'>Failed to removed the current image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();//stop the process
                        }
                    }
                }
                else
                {
                    $image_name=$current_image;
                }  
            }
            else
            {
                $image_name=$current_image;
            }


            //step3:Update the database
            $sql2="UPDATE tbl_category SET
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            WHERE id=$id";

            $res2=mysqli_query($conn,$sql2);


            //step4:Redirect to the manage-category page

            if($res2==true)
            {
                $_SESSION['update']="<div class='success'>Category updated successfully.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');

            }
            else
            {
                $_SESSION['update']="<div class='error'>Failed to add Category.</div>";
                header('location:'.SITEURL.'/admin/manage-category.php');
            }
        
        }


        ?>

        </div>
</div>
<?php include ('partials/footer.php'); 
?>