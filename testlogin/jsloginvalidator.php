<?php
include_once "model/account_model.php";

$account_model                  =   new Account_model();

if (!isset($_POST['login_user_name']) || !isset($_POST['login_password']))
{
    echo "UNAVAILABLE";
    exit();
}

if ($account_model->is_valid_login($_POST['login_user_name'], $_POST['login_password']) == "LOGIN")
{
    session_start();
    
    $_SESSION['username'] = $_POST['login_user_name'];
    $_SESSION['is_user_loggedin'] = true;
    
    echo "VALID";
    exit();
}
else
{
    echo "INVALID";
    exit();
}
?>