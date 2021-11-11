<?php
    include ('partials/menu.php')
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        
        <br><br>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
        ?>
        
        <!-- Add Category From Starts-->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td >
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No" checked> No
                    </td>
                </tr>


                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No" checked> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        <!-- Tạo nút back-->
                        <input type="button" value="Go Back" onclick="history.back(-1);" class="btn-danger" />
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category From End-->

        <?php

            //Check whether the Submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                
                //1. Get the Value from Category Form
                $title = $_POST['title'];
                
                //For Radio input, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //Get the Value from Form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Set the Default Value
                    $featured = 'No';
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = 'No';
                }

                // echo $title .'</br>';
                // echo $featured .'</br>'; 
                // echo $active;
                
                //Check whether the image is selected or not and set the value for image name accordingly
                // var_dump($_FILES['image']);

                // die(); // Break the code here
                
                if(isset($_FILES['image']['name']))
                {  
                    //Upload the Image
                    //To upload image we need image name, source patch and destination patch
                    $image_name = $_FILES['image']['name'];

                    
                    //Upload the Image only if image is selected
                    
                    if($image_name != '')
                    {
                        // //Auto Rename our Image
                        // //Get the Extension of our image (jpg, png, gif, etc) e.g "food1.jpg"
                        $ext = end(explode('.',$image_name));
    
                        // //Rename the Image
                        $image_name = "Food_Category_".rand(000,999).'.'.$ext;  //e.g Food_Category_156.jpg
    
                        $source_patch = $_FILES['image']["tmp_name"];
    
                        $destination_patch ="../images/category/".$image_name;
    
                        //Finally upload the Image
                        $upload = move_uploaded_file($source_patch,$destination_patch);
    
                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded the we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            // Tắt 3 dòng này nếu để muốn set ảnh mặc định khi không upload ảnh.
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-category.php');
                            //Stop process
                            die();
                        }

                    }
                
                }
                else
                {
                    //Don't upload image and set the image_name value as blank
                    $image_name="";

                }

                            
                //2. Create SQL Query to Insert Category into Database
                $sql = "INSERT INTO tbl_category SET 
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active' ";

                //3. Execute the Query and Save in Database.
                $res = mysqli_query($conn,$sql);

                //4. Check whether the query executed or not and data added or not
                if($res==True)
                {
                    //Query Executed and Category Added
                    $_SESSION['add'] = '<div class="success">Category Added Successfully</div>';
                    //Redirect to Manage Category
                    header("location:".SITEURL.'admin/manage-category.php');
                }
                else
                {
                    $_SESSION['add'] = '<div class="error">Failed to Add Category</div>';
                    header("location:".SITEURL.'admin/add-category.php');
                }
            }
        ?>
    </div>
</div>
<?php
    include ('partials/footer.php')
?>


<script>
    function validateForm()
    {
        var title = document.getElementById('title').value;
    
        // Bước 2: Kiểm tra dữ liệu hợp lệ hay không
        if (title == ''){
            alert('Bạn chưa nhập title');
        }
        
    }
</script>