<?php

include_once "model/account_model.php";

if (isset($_POST['new_account_user_name']))
{
    $account                            =   new Account($_POST['new_account_first_name'],
                                                        $_POST['new_account_last_name'],
                                                        $_POST['new_account_user_name'],
                                                        $_POST['new_account_password'],
                                                        $_POST['new_account_password_re']
                                                    );
    $account_model                      =   new Account_model();
    $account_model->account             =   $account;
    $errors                             =   $account_model->validate();
    if(count($errors) == 0)
    {
        $response                       =   $account_model->insert();
        if ($response == '')
        {
            header('Location: /testlogin/plainpage.php?param=signup');
            exit();
        }
        else
        {
            echo $response;
            show_form(array());
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

function show_form($errors)
{
    ?>
    <html>
        <head>
            <title>Test Login System</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
        <body>
            <form action='' method='post' onsubmit="return submit_signup()">
                <h2>Create Account</h2>
                <ul class='ul-no-style'>
                    <li>
                        <input placeholder='First Name' type='text' class='form-text' name='new_account_first_name' id='new_account_first_name' value='<?php echo isset($_POST['new_account_first_name']) ? $_POST['new_account_first_name'] : ''; ?>' />
                        <span class='error block' id='error_new_account_first_name'><?php echo (isset($errors['new_account_first_name'])) ? $errors['new_account_first_name'] : ''; ?></span>
                    </li>
                    <li>
                        <input placeholder='Last Name' type='text' class='form-text' name='new_account_last_name' id='new_account_last_name' value='<?php echo isset($_POST['new_account_last_name']) ? $_POST['new_account_last_name'] : ''; ?>' />
                        <span class='error block' id='error_new_account_last_name'><?php echo (isset($errors['new_account_last_name'])) ? $errors['new_account_last_name'] : ''; ?></span>
                    </li>
                    <li>
                        <input placeholder='User Name' type='text' class='form-text' name='new_account_user_name' id='new_account_user_name' value='<?php echo isset($_POST['new_account_user_name']) ? $_POST['new_account_user_name'] : ''; ?>' />
                        <span class='error block' id='error_new_account_user_name'><?php echo (isset($errors['new_account_user_name'])) ? $errors['new_account_user_name'] : ''; ?></span>
                    </li>
                    <li>
                        <input placeholder='Password' type='password' class='form-text' name='new_account_password' id='new_account_password' />
                        <span class='error block' id='error_new_account_password'><?php echo (isset($errors['new_account_password'])) ? $errors['new_account_password'] : ''; ?></span>
                    </li>
                    <li>
                        <input placeholder='Reenter password' type='password' class='form-text' name='new_account_password_re' id='new_account_password_re' />
                        <span class='error block' id='error_new_account_password_re'><?php echo (isset($errors['new_account_password_re'])) ? $errors['new_account_password_re'] : ''; ?></span>
                    </li>
                    <li>
                        <input type='submit' class='form-submit' value='Submit' name='new_account_submit' id='new_account_submit' />
                    </li>
                </ul>
            </form>
            <a href='login.php'>Login</a>
        </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="./js/signup.js"></script>
    </html>
    <?php
}
?>