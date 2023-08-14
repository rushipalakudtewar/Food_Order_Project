<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        
        <br><br>
        <?php    
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        //enctype="multipart/form-data" is used to upload the file
        ?>
            <br><br>
        <form action=""method="POST" enctype="multipart/form-data">
               
            <table class="tbl-30">
            <tr> 
                <td>Title:</td>
                <td><input type="text"name="title"placeholder="Category title">
                </td>
            </tr>
            <tr>
            <td>Select Image:</td>
            <td><input type="file"name="image"></td>
            </tr>

            <tr>
            <td>Featured:</td>
            <td>
            <input type="radio"name="featured"value="Yes">Yes
            <input type="radio"name="featured"value="No">No
            </td>
            </tr>

            <tr>
            <td>Active:</td>
            <td>
            <input type="radio"name="active"value="Yes">Yes
            <input type="radio"name="active"value="No">No
            </td>
            </tr>

            <tr>
            <td colspan="2">
            <input type="submit"name="submit"value="add category"class="btn-secondary">
            </td>
            </tr>
            </table>
        </form>


        <?php
        if(isset($_POST['submit']))
        {
            //    echo "Button is clicked";
            //step1:Get the title value from Form
            $title=$_POST['title'];
            
            //Get the featured value
            if(isset($_POST['featured']))
            {
                $featured=$_POST['featured'];

            }
            else
            {
                //set as the default value
                $featured="No";
            }
            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
            }
            else
            {
               $active="No";
            }
            //check whether the image is selected or not and set the value  of image name accordingly
            //print_r($_FILES['image']);
            //die(); //Break the code here
            if(isset($_FILES['image']['name']))
            {
                //display the image
                $image_name=$_FILES['image']['name'];
                if($image_name!="")
                {
                //Auto rename our Image
                //get the extension of our image (jpg,png,gif,etc)eg."food1.jpg"
                $ext=end(explode('.',$image_name));

                //Rename the image
                $image_name="Food_category_".rand(000,999).'.'.$ext; //after renaming the img ex.has shown Food_Category_324.jpg

                $source_path=$_FILES['image']['tmp_name'];

                $destination_path="../images/category/".$image_name;

                //Finally upload the image
                $upload=move_uploaded_file($source_path,$destination_path);


                //check whether the image is uploaded or not uploaded
                //if the image is not uploaded then we will stop the process and redirect to the error message
                if($upload==false)
                {
                    $_SESSION['upload']="<div class='error'>Failed to upload the image</div>";
                    //Redirect to add category page
                    header('location:'.SITEURL.'admin/add-category.php');
                    //Stop the process
                    die();
                }
            }
            }
            else
            {
                $image_name="";
                //Don't upload the image and set the image name value is the blank
            }

            //Create SQL query to insert categary into the database 
            $sql="INSERT INTO tbl_category SET 
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'";
            
            //execute the query and connect or save in the database
            $res=mysqli_query($conn,$sql);
            
            //check the query is executed successfully or not
            if($res==true)
            {
                //echo "query executed successfully";
                $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            
            }
            else
            {
                //echo "query is not executed successfully";
                $_SESSION['add']="<div class='error'>Failed to Add category</div>";
                header('location:'.SITEURL.'admin/add-category.php');
            }


        }
        
        ?>
    </div>

</div>



<?php include('partials/footer.php'); ?>