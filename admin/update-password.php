<?php  
    include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" value="" placeholder="Old Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" value="" placeholder="New Password" >
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" value="" placeholder="Confirm Password" >
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" class="btn-secondary" value="Change Password" name="submit" >
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Clicked";

        //1. Get the data from Form
            $id = $_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);
        
        //2. Check whether the user with current ID and Current Password Exists or Not
        $sql = "SELECT * FROM tbl_admin Where id=$id AND password='$current_password'";

        // Execute the Query
        $res = mysqli_query($conn , $sql);
        
        if($res==True)
        {
            //Check whether data is available or not
            $count = mysqli_num_rows($res);
            
            if($count==1)    // Chỉ nhận 1 giá trị id duy nhất 
            {
                //User Exists and Password can be changed
                // echo "User Found";

                // Check whether the new password and confirm password match or not
                if($new_password==$confirm_password && $new_password!='')
                {
                    
                    //Update Password
                    // echo 'Update successfully';
                    $sql2= "UPDATE tbl_admin SET password='$new_password' where id=$id; ";

                    // Execute the Query
                    $res2 = mysqli_query($conn,$sql2);

                    if($res2==true)
                    {
                        // Display Successfully message
                        //Redirect to Manage Admin Page with Successfully Message
                        $_SESSION['change-pwd'] = "<div class='success'>Update Password Successfully. </div>";
                        //Redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        // Display Error Message
                        //Redirect to Manage Admin Page with Error Message
                        $_SESSION['change-pwd'] = "<div class='error'>Fail Update Password. </div>";
                        //Redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //Redirect to Manage Admin Page with Message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did not Match. </div>";
                    //Redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //User Does not Exits Set Message and Redirect
                $_SESSION['user-not-found'] = "<div class='error'>User not Found. </div>";
                //Redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        //3. Check whether the New Password and Confirm Password Match or not

        //4. Change Password if all above is true
    }
?>

<?php
    include ('partials/footer.php');
?>