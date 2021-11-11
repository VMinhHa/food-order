<?php
    include ('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            //1. Get the ID of selected Admin
            $id=$_GET['id'];
            
            //2. Create SQL Query to Get the Details
            $sql="SELECT * From tbl_admin where id=$id";

            //Execute the Query
            $res = mysqli_query($conn,$sql);
            
            //Check whether the query is executed or not
            if($res==True)
            {
                // Check whether the data is variable or not
                $count = mysqli_num_rows($res);
                //Check whether we have admin data or not
                if($count==1)   // Chỉ nhận 1 giá trị id duy nhất
                {
                    // Get the Details
                    // echo "admin avail";
                    $rows = mysqli_fetch_assoc($res);

                    $full_name = $rows['full_name'];
                    $username = $rows['username'];

                }
                else
                {
                    //Redirect to Manage Admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }

        ?>
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name;?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username;?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value= "<?php echo $id; ?> ">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php
    if(isset($_POST['submit']))
    {
        //Button Clicked
        
        //Get all the values from form
        $id = $_POST['id'];
        $full_name= $_POST['full_name'];
        $username = $_POST['username'];

        //Create a SQL query to Update Admin
        $sql = "Update tbl_admin SET
            full_name='$full_name',
            username='$username'
            WHERE id='$id'
        ";

        //Connecting SQL
        //3. Execute Query and Save data
        $res = mysqli_query($conn,$sql);

        //4. Check whether the (Query is Executed) data is inserted or not and display.
        if($res=TRUE)
        {
              //Data inserted
            //  echo "Data inserted";

            // Create a Session Variable to Display Mess
            $_SESSION['update'] = "<div class='success'>Admin Update Successfully. </div>";
            //Redirect Page tp Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');          
        }
        else
        {
            //Failed
            // echo "Fail";
            
            // Create a Session Variable to Display Mess
            $_SESSION['update']= "<div class='error'>Failed to Update Admin.</div>";
            //Redirect Page tp Add Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }
?>

<?php
    include ('partials/footer.php');
?>