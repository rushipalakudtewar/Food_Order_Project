<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>update admin</h1>
        <br><br>

        <?php
            //step1:Get the id of selected admin
            $id=$_GET['id'];

            //step2:create sql query to get the details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //step3:execute the query
            $res=mysqli_query($conn,$sql);
            //step4:check whether the query is executed or not
            if($res==true)
            {
                $count=mysqli_num_rows($res);
            //check whether we have admin data or not
            if($count==1)
            {
                //if the query  is executed 
                //echo "Admin available";
                $row=mysqli_fetch_assoc($res);
                $full_name=$row['full_name'];
                $username=$row['username'];
            }
            else
            {
                //Redirecting the manage admin page
                header("location:".SITEURL."admin/manage-admin.php");
            }
            }
        ?>

        <form action=""method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text"name="full name"value="<?php echo $full_name; ?>">
                    </td>

                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text"name="username"value="<?php echo $username; ?>">
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden"name="id"value="<?php echo $id; ?>">
                        <input type="submit"name="submit"value="Update Admin"class="btn-secondary">

                    </td>
                </tr>
            </table>
    </div>
</div>

<?php
    if(isset($_POST["submit"]))
    {
        //echo "button clicked";
        $id=$_POST['id'];
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];

        //create sql query to update the data in the database 
        $sql="UPDATE tbl_admin SET
        full_name='$full_name',
        username='$username'
        WHERE id='$id'
        ";
        //execute the query 
        $res=mysqli_query($conn,$sql);

        //check whether the query is executed or not
        if($res==true)
        {
            //echo "query executed successfully";
            $_SESSION['update']="<div class='success'>Admin added succesfully.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //echo "query is not executed";
            $_SESSION['update']="<div class='error'>Try Again Later.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }

    }



?>







<?php include('partials/footer.php'); ?>
