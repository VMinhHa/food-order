<?php
    include ('../config/constrants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br><br>

        <!-- Login Form Starts -->
            <form action="" method="POST" class="text-center">
                <label for="user">Username: </label> <br>
                    <input type="text" name="username" id="user" placeholder="Enter Username"> <br> <br>
                
                <label for="pass">Password: </label> <br>
                    <input type="password" name="password" id="pass" placeholder="Enter Password"> <br> <br>

                <input type="submit" value="Login" name="submit" class="btn-primary">
                <br><br>
            </form>
        <!-- Login Form End -->

        <p class="text-center">Created By - <a href="">Minh Ha</a></p>
    </div>
</body>
</html>

<?php
    //Check whether the Submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // Process for Login
        //1 . Get the Data from Login form
        $username= $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL to check whether the user with username and password exits or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' and password='$password'";

        //3. Execute the Query
        $res = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exits or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User Available and Login Success
            $_SESSION['login'] = "<div class='success'> Login Success</div>";
            $_SESSION['user'] = $username;  // To check whether the user is logged in or not and logout will unset it
            
            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User not Available and Login Error
            $_SESSION['login'] = "<div class='error text-center'> Username or Password did not match</div>";
            //Redirect to Login form
            header('location:'.SITEURL.'admin/login.php');
        }
    }
?>