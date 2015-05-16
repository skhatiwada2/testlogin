function submit_login()
{
    var username = $('#login_user_name').val();
    var password = $('#login_password').val();
    
    var valid = true;
    if (username == '')
    {
        $('#error_login_user_name').html('User name is required');
        valid = false;
    }
    else
    {
        $('#error_login_user_name').html('');
    }
    
    if (password == '')
    {
        $('#error_login_password').html('Password is required');
        valid = false;
    }
    else
    {
        $('#error_login_password').html('');
    }
    
    if (valid)
    {
        $.post("jsloginvalidator.php", { login_user_name: username, login_password: password }, function(data)
               {
                    if (data == "INVALID")
                    {
                        $('#error_login_password').html('User name or password did not match');
                    }
                    else if (data == "UNAVAILABLE")
                    {
                        $('#error_login_password').html("User name or password not available");
                    }
                    else if(data == "VALID")
                    {
                        $('#ajax_login_info').html("Login valid. redirecting...");
                        setTimeout(function() {window.location.href = "/testlogin/plainpage.php?param=login";}, 1000);
                    }
               });
    }
    
    return false;
}