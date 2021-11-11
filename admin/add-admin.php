<?php
    include ('partials/menu.php');
?>

<div class="main-content">
        <div class="wrapper">
            <h1>Add Admin</h1>

            <br><br>

            <?php
                if(isset($_SESSION['add'])) //Checking whether the Session is set of not.
                {
                    echo  $_SESSION['add']; //Display the session message if set.
                    unset($_SESSION['add']); //Remove session message.
                }
            ?>
            <form action="" method="POST">

                <table class="tbl-30">
                    <tr>
                        <td><label for="txtname">Full name: </label></td>
                        <td>
                            <input type="text" name="full_name" id="txtname" placeholder="Enter Your Name" require>
                    </tr>
                    
                    <tr>
                        <td><label for="txtuser">Username: </label></td>
                        <td>
                            <input type="text" name="username" id="txtuser" placeholder="Your Username" require>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="txtpass">Password: </label></td>
                        <td>
                            <input type="password" name="password" id="txtpass" placeholder="Your Password" require>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-primary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
</div>

<?php
    include ('partials/footer.php');
?>

<?php
    //Process the Value from Form and Save it.
    //Check whether the button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button Clicked
        
        //1. Get the data from form
        $full_name= $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);    //Password Encryption with MD5

        //2. SQL Query to save the data
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //Connecting SQL
        //3. Execute Query and Save data
        $res = mysqli_query($conn,$sql) or die(mysqli_error());

        //4. Check whether the (Query is Executed) data is inserted or not and display.
        if($res=TRUE)
        {
              //Data inserted
            //  echo "Data inserted";
            // Create a Session Variable to Display Mess
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully </div>";
            //Redirect Page tp Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');          
        }
        else
        {
            //Failed
            // echo "Fail";
            // Create a Session Variable to Display Mess
            $_SESSION['add'] = "<div class='success'>Failed to Add Admin </div>";
            //Redirect Page tp Add Admin
            header("location:".SITEURL.'admin/add-admin.php');
        }
        
    }
?>