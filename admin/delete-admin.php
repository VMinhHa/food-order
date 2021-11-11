<?php
    //Include constants.php
    include ('../config/constrants.php');
    //1. Get the ID of Admin to be deleted
        $id=$_GET['id'];

    //2. Create SQL query to Delete Admin
        $sql= "DELETE FROM tbl_admin where id=$id";

    //Execute the Query
        $res = mysqli_query($conn,$sql);
    // Check whether the query executed successfully or not 
        if($res==TRUE)
        {
            //Query Executed Successfully and Admin Deleted
            //eco "Admin Deleted";
            //Create Session Variable to Display Message
            $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
            //Redirect to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Failed to Delete Admin
            //echo "Failed to Delete Admin";
            
            $_SESSION['delete']= "<div class='error'>Failed to Delete Admin.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    //3. Redirect to Manage Admin page with message (success/error)

?>