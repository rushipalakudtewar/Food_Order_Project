<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
            <br><br>
            <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    
                            <tr>
                            <td>Title:</td>
                            <td><input type="text"name="title"placeholder="title of the food"></td>
                            </tr>
                            
                            <tr>
                            <td>Description:</td>
                            <td><textarea name="description"cols="30" rows="5" placeholder="description of food"></textarea></td>
                            </tr>
                            <tr>
                            <td>Price:</td>
                            <td><input type="number"name="price"></td>
                            </tr>
                            
                            <tr>
                            <td>Select file:</td>
                            <td><input type="file"name="image"></td>
                            </tr>
                            
                            <tr>
                            <td>Category:</td>
                            <td><select name="category">

                                <?php
                                //Create the PHP code to display categories from the database
                                //step1:Create sql query to get all the active categories from the database
                                $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                                //execute the query 
                                $res=mysqli_query($conn,$sql);
                             
                                //count rows to check whether we have categories or not
                                $count=mysqli_num_rows($res);

                                if($count>0)
                                {
                                    //if have category
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $id=$row['id'];
                                        $title=$row ['title'];
                                        
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php

                                    }
                                }
                                else
                                {
                                    //If do not have any category
                                    ?>
                                    
                                     <option value="0">No category found</option>

                                    <?php

                                }
                                    
                                ?>       
                                
                             </select>
                            </td>
                            </tr>

                            <tr>
                            <td>Featured:</td>
                            <td><input type="radio"name="featured"value="Yes">Yes
                                <input type="radio"name="featured"value="No">No
                            </td>
                            </tr>

                            <tr>
                            <td>Active:</td>
                            <td><input type="radio"name="active"value="Yes">Yes
                                <input type="radio"name="active"value="No">No
                            </td>
                            </tr>
                            
                            <tr>
                            <td><input type="submit"name="submit" value="Add Food"class="btn-secondary"></td>
                            </tr>
                </table>
            
            
            </form>
            <?php
            if(isset($_POST['submit']))
            {
             //   echo "clicked";
             //Get the data form the database
             $title=$_POST['title'];
             $description=$_POST['description'];
             $price=$_POST['price'];
             $category=$_POST['category'];

             //check whether featured and active is checked or not 
             if(isset($_POST['featured']))
             {
                 $featured=$_POST['featured'];

             }
             else
             {
                 $featured="No";//setting as default value
             }
             //also check active
             if(isset($_POST['active']))
             {
                 $active=$_POST['active'];

             }
             else
             {
                 $active="No";//setting as default value
             }
            

            //2.Upload the image if selected
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
                $image_name="Food_category_".rand(0000,9999).'.'.$ext; //after renaming the img ex.has shown Food_Category_324.jpg

                $source_path=$_FILES['image']['tmp_name'];

                $destination_path="../images/food/".$image_name;

                //Finally upload the image
                $upload=move_uploaded_file($source_path,$destination_path);


                //check whether the image is uploaded or not uploaded
                //if the image is not uploaded then we will stop the process and redirect to the error message
                if($upload==false)
                {
                    $_SESSION['upload']="<div class='error'>Failed to upload the image</div>";
                    //Redirect to add category page
                    header('location:'.SITEURL.'admin/add-food.php');
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
            

            
            //3.Insert into the database
            //for numerical value do not need to pass value inside quotes '' but for string vallue it is compulsory to add quotes ''
            $sql2 = "INSERT INTO tbl_food SET title='$title',description='$description',price='$price',image_name='$image_name',category_id='$category',featured='$featured',active='$active'";
            
            $res2 = mysqli_query($conn,$sql2);


            //4.Redirect to the manage admin page
            if($res2==true)
            {
                //Data inserted successfully
                $_SESSION['add']="<div class='success'>Food added successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');

            }
            else
            {
                $_SESSION['add']="<div class='error'>Failed to add the food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                
            }
        }
     ?>       
     </div>
 </div>


<?php include('partials/footer.php'); ?>
