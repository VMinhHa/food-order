<?php
    //Include constants.php for SITEURL
    include('../config/constrants.php');
    //1. Destroy the Session
    session_destroy();  //Unset $_Session['user']
    //2. Redirect to Login Page
    header('location:'.SITEURL.'admin/login.php');
?>