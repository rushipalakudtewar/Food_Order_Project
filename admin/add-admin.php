<?php include("partials/menu.php"); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <?php
        if(isset($_SESSION['add']))//check the session
        {
            echo $_SESSION['add'];//display the session
            unset($_SESSION['add']);//remove the session
        }
        
        ?>
        <form action=""method="POST">
            <table class="tbl-30">
                <tr>
                <td>Full Name:</td>
                <td><input type="text" name="full_name" placeholder="Enter the name"></td>
                </tr>
                <tr>
                <td>Username:</td>
                <td><input type="text" name="username" placeholder="Enter the username"></td>
                </tr>
                <tr>
                <td>Password:</td>
                <td><input type="password" name="password" placeholder="Enter the password"></td>
                </tr>
                <tr>
                <td colspan="2">
                <input type="submit" name="submit" value="Add Admin" class="btn_secondary">
                </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include("partials/footer.php"); ?>

<?php
    //process the value from form and save it in database
    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Button clicked
        //echo "btn clicked";

        //step1:-Get the data from Form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];//password encrytion with MD5
        
        //step2:-SQL query to save the data into the database
        $sql = "INSERT INTO tbl_admin SET
                full_name='$full_name',
                username='$username',
                password='$password'
                ";

        //step3:-Executing query and saving in the database        
        $res = mysqli_query($conn,$sql) or die(mysqli_error());
        
        //step4:-check whether the data inserted or not in the database
        if($res==TRUE)
        {
            //Data inserted
            //echo "Data inserted successfully";
            //create a seesion variable to display message
            $_SESSION['add']="<div class='success'>Admin added successfully</div>";
            //Redirect page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Data not inserted
            //echo "Data is not inserted successfully";
           //create a seesion variable to display message
           $_SESSION['add']="<div class='error'>Failed to add admin</div>";
           //Redirect page
           header("location:".SITEURL.'admin/add-admin.php');
       
        }
    
    }
    
?>


