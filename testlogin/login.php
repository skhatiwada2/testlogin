<?php
include_once "model/account_model.php";

if(isset($_POST['login_user_name']) && isset($_POST['login_password']))
{
    $account_model                  =   new Account_model();
    
    $errors = $account_model->validate_login_form($_POST['login_user_name'], $_POST['login_password']);
    if (count($errors) == 0)
    {
        if ($account_model->is_valid_login($_POST['login_user_name'], $_POST['login_password']) == "LOGIN")
        {
            start_session_for_user($_POST['login_user_name']);
        }
        else
        {
            show_form(array('login_password' => 'User name or password did not match'));
        }
    }
    else
    {
        show_form($errors);
    }
}
else
{
    show_form(array());
}

function start_session_for_user($login_user_name)
{
    session_start();
    
    $_SESSION['username'] = $login_user_name;
    $_SESSION['is_user_loggedin'] = true;
    
    header("Location: /testlogin/plainpage.php?param=login");
    exit();
}

function show_form($errors)
{
    ?>
    <html>
        <head>
            <title>Login</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
        <body>
            <h2>Login</h2>
            <form method='post' action='' onsubmit='return submit_login()'>
                <ul class='ul-no-style'>
                    <li>
                        <input type='text' class='form-text' name='login_user_name' id='login_user_name' value='<?php echo isset($_POST['login_user_name']) ? $_POST['login_user_name'] : ''; ?>' />
                        <span class='block error' id='error_login_user_name'><?php echo (isset($errors['login_user_name'])) ? $errors['login_user_name'] : ''; ?></span>
                    </li>
                    <li>
                        <input type='password' class='form-text' name='login_password' id='login_password' value='<?php echo isset($_POST['login_password']) ? $_POST['login_password'] : ''; ?>' />
                        <span class='block error' id='error_login_password'><?php echo (isset($errors['login_password'])) ? $errors['login_password'] : ''; ?></span>
                    </li>
                    <li>
                        <input type='submit' class='form-submit' name='login_submit' id='login_submit' />
                    </li>
                </ul>
            </form>
            <div class='block' id='ajax_login_info'></div>
        </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="./js/login.js"></script>
    </html>
    <?php
}
?>