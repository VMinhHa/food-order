<?php 
    include ('../config/constrants.php');
    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) and isset($_GET['image_name']))
    {   
        //Get value and delete
        // echo "Get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available
        if($image_name != "")
        {
            //Image is Available. So remove it.
            $path = "../images/category/".$image_name;
            //Remove the Image
            $remove = unlink($path);

            //If failed to remove image the add an error message and stop the process
            if($remove==false)
            {
                //Set the Session Mess
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Images.</div>";
                //Redirect to Manage Category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //Stop the Process
                die();
            }
        }
        //Delete Data from database
        //Sql Query to Delete from database
        $sql = "DELETE FROM tbl_category where id='$id'";

        //Excute the Query
        $res = mysqli_query($conn,$sql);

        //Check whether the data is delete from database or not
        if($res==True)
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'> Category Deleted Successfully.</div>";
            //Redirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Set Fail Message and Redirect
            $_SESSION['delete'] = "<div class='error'> Failed to Delete Category.</div>";
            //Redirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        

    }
    else
    {
        //Redirect to Manage Category Page
        header("location:".SITEURL.'admin/manage-category.php');
    }
?>

