<?php

$value = $_GET['param'];

if ($value == 'login')
{
    session_start();
    echo "Redirected from login. Session Info: <br />" ;
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
}
elseif($value == 'signup')
{
    echo "Redirect from signup. Signup successful. <a href='login.php'>Login Here</a>";
}

?>