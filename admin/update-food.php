<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
        if(isset($_GET['id']))
        {
            //Getting the id from the database
            $id=$_GET['id'];
            //Write the query for fetching the values
            $sql="SELECT * FROM tbl_food WHERE id=$id";

            //Connect the database
            $res=mysqli_query($conn,$sql);
            //check the count only one row is selected or not
            $count=mysqli_num_rows($res);
            if($count==1)
            {
                    $row=mysqli_fetch_assoc($res);
                    $title=$row['title'];
                    $description=$row['description'];
                    $current_image=$row['image_name'];
                    $current_category=$row['category_id'];
                    $price=$row['price'];
                    $featured=$row['featured'];
                    $active=$row['active'];
            }
            else
            {
                //echo "not got";
                $_SESSION['no-food-found']="<div class='error'>Food Not Found</div>";
                header('location:'.SITEURL.'/admin/manage-food.php');
            }




        }
        else
        {
            //echo "Not got id";
            //Redirecting to the manage-food page
            header('location:'.SITEURL.'/admin/manage-food.php');

        }
        ?>
          
    <form action=""method="POST"enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
            <td>Title:</td>
            <td><input type="text"name="title"value="<?php echo $title ?>">
            </td>
            </tr>
            <tr>
            <td>Description:</td>
            <td><textarea name="description" cols="30" rows="5"><?php echo $description ?></textarea></td>
            </tr>
            <tr>
            <td>Price:</td>
            <td><input type="number"name="price" value="<?php echo $price ?>"></td>
            </tr>
            <tr>
            <td>Current Image:</td>
            <td><?php
                        if($current_image!="")
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>"width=150px >
                            <?php
                        }
                        else{
                            
                           echo "<div class='error'>Image Not Added.</div>";
                           
                        }
                        ?></td>



            </tr>
            
            <tr>
            <td>New Image:</td>
            <td><input type="file"name="image">
            </td>
            </tr>
            
            <tr>
            <td>Category</td>
            <td><select name="category">
            <?php

            $sql2="SELECT * FROM tbl_category WHERE active='Yes'";
            
            $res2=mysqli_query($conn,$sql2);

            $count2=mysqli_num_rows($res2);

            if($count2>0)
            {
                while($row2=mysqli_fetch_assoc($res2))
                {
                        $category_title=$row2['title'];
                        $category_id=$row2['id'];
                        echo "<option value='$category_id'>$category_title</option>";
                }

            }
            else
            {
                echo "<option value='0'>Category not available.</option>";
            }

            ?>
            
            </select>
            </tr>

            <tr>
            <td>Featured:</td>
            <td><input <?php if($featured=="Yes") {echo "Checked";} ?> type="radio"name="featured"value="Yes">Yes
            <input <?php if($featured=="No") {echo "Checked";} ?> type="radio"name="featured"value="No">No
            </td>
            </tr>

            <tr>
            <td>Active:</td>
            <td><input <?php if($active=="Yes") {echo "Checked"; } ?> type="radio"name="active"value="Yes">Yes
            <input <?php if($active=="No") {echo "Checked"; } ?> type="radio"name="active"value="No">No
            </td>
            </tr>

            <tr>
            <td>
            <input type="hidden"name="id" value="<?php echo  $id; ?>">
            <input type="hidden"name="current_image" value="<?php echo $current_image; ?>">
            <input type="submit"name="submit"class="btn-secondary">
            </td>
            </tr>
        
        
        
        
        </table>
        </form>



    <?php           

        if(isset($_POST['submit']))
        {
            //Step 1:Get the data from the FORM
            $id=$_POST['id'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $current_image=$_POST['current_image'];
            $category=$_POST['category'];
            $featured=$_POST['featured'];
            $active=$_POST['active'];

            //Step2:Upload the image is selected
            if($_FILES['image']['name'])
            {
                $image_name=$_FILES['image']['name'];

                if($image_name!="")
                {
                    $ext=end(explode('.',$image_name));//Get the extension of image
                    $image_name="Food_name".rand(0000,9999).'.'.$ext;//Rename the image
                    $src=$_FILES['image']['tmp_name'];
                    $destination_path="../images/food/".$image_name;

                    $upload=move_uploaded_file($src,$destination_path);
                    //if check whether file is uploaded or not

                    if($upload==false)
                    {
                        $_SESSION['upload']="<div class='error'>Failed to upload the image.</div>";
                        header('location:'.SITEURL.'/admin/manage-food.php');
                        die();
                    }
                 //step3:If new image is uploaded then remove the currrent image
                    if($current_image!="")
                    {
                        $remove_path="../images/food/".$current_image;
                        $remove=unlink($remove_path);
                        if($remove=false)
                        {
                            $_SESSION['remove']="<div class='error'>Current image is not Deleted.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
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


           

            //step 4:Update the data from the database
            $sql3="UPDATE tbl_food SET
            title='$title',
            description='$description',
            price='$price',
            image_name='$image_name',
            category_id='$category',
            featured='$featured',
            active='$active'
            WHERE id=$id";

            $res3=mysqli_query($conn,$sql3);
            //Redirecting to the manage-food page
            if($res3==true)
            {
                $_SESSION['update']="<div class='success'>Food Updated Successfully</div>";
                header('location:'.SITEURL.'/admin/manage-food.php');

            }
            else
            {
                
                $_SESSION['update']="<div class='error'>Failed to Update the Food.</div>";
                header('location:'.SITEURL.'/admin/manage-food.php');

            }

        }
    ?>
    </div>
    </div>


<?php include('partials/footer.php'); ?>