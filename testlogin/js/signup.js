function submit_signup()
{
    var first_name = $('#new_account_first_name').val();
    var last_name = $('#new_account_last_name').val();
    var user_name = $('#new_account_user_name').val();
    var password = $('#new_account_password').val();
    var password_re = $('#new_account_password_re').val();
    
    var valid = true;
    
    if (first_name == '')
    {
        $('#error_new_account_first_name').html('First Name is required');
        valid = false;
    }
    else
    {
        $('#error_new_account_first_name').html('');
    }
    
    if (last_name == '')
    {
        $('#error_new_account_last_name').html('last Name is required');
        valid = false;
    }
    else
    {
        $('#error_new_account_last_name').html('');
    }
    
    if (user_name == '')
    {
        $('#error_new_account_user_name').html('User Name is required');
        valid = false;
    }
    else
    {
        $('#error_new_account_user_name').html('');
    }
    
    if (password == '')
    {
        $('#error_new_account_password').html('Password is required');
        valid = false;
    }
    else
    {
        $('#error_new_account_password').html('');
    }
    
    if (password_re == '')
    {
        $('#error_new_account_password_re').html('Password Verification is required');
        valid = false;
    }
    else if (password != password_re)
    {
        $('#error_new_account_password_re').html('Password did not match');
        valid = false;
    }
    else
    {
        $('#error_new_account_password_re').html('');
    }
    
    return valid;
}
