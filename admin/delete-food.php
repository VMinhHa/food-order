<?php
    include ('../config/constrants.php');
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != "")
        {
            //Image is Available. So remove it.
            $path = "../images/food/".$image_name;
            //Remove the Image
            $remove = unlink($path);

            //If failed to remove image the add an error message and stop the process
            if($remove == false)
            {
                //Set the Session Mess
                $_SESSION['remove-food'] = "<div class='error'>Failed to Remove Images.</div>";
                //Redirect to Manage Category page
                header('location:'.SITEURL.'admin/manage-food.php');
                //Stop the Process
                die();
            }
        }

        $sql = "DELETE From tbl_food where id='$id'";
        $res = mysqli_query($conn, $sql);
    
        if($res==TRUE)
        {
            $_SESSION['delete-food'] = "<div class='success'>Food Delete-food Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['delete-food'] = "<div class='error'>Failed to Delete Food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access..</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }