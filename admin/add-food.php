<?php include('partials/menu.php')?>
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
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Title..">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea type="text" name="description" cols="30" rows="5" placeholder="Enter Description.."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>

                        <select name="category">
                    
                            <?php 
                                //Create PHP Code to display categories from Database
                                //1. CReate SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                
                                //Executing qUery
                                $res = mysqli_query($conn, $sql);

                                //Count Rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //IF count is greater than zero, we have categories else we donot have categories
                                if($count>0)
                                {
                                    //WE have categories
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <option value="0">No Category Found</option>
                                    <?php
                                }
                            ?>
                            
                        </select>

                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No" >No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No" >No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";
                }
                
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //2. Upload the image if selected
                //Check whether the select image is clicked or not and upload the image only if the image is selected
                
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
                        $image_name = "Food_Name-".rand(000,999).'.'.$ext;  //e.g Food_Category_156.jpg
    
                        $src = $_FILES['image']["tmp_name"];
    
                        $des ="../images/food/".$image_name;
    
                        //Finally upload the Image
                        $upload = move_uploaded_file($src,$des);
    
                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded the we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
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

                //For numberical we do not need to pass value inside quotes ''
                //but for string value it is compulsory to add quotes.
                $sql2 = "INSERT INTO tbl_food (title,description,price,image_name,category_id,featured,active) 
                VALUES ('$title','$description',$price,'$image_name', '$category', '$featured', '$active')";
                // $sql2 = "INSERT INTO tbl_food SET 
                // title = '$title',
                // description = '$description',
                // price = $price,
                // image_name = '$image_name',
                // category_id = $category,
                // featured = '$featured',
                // active = '$active'
            //";
                $res2 = mysqli_query($conn,$sql2);

                if($res2==true)
                {
                    $_SESSION['add-food'] = "<div class='success'>Food Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['add-food'] = "<div class='error'>Failed to Add Food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }

            
        ?>

    </div>
</div>

<?php include('partials/footer.php');