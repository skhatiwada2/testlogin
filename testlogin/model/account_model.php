<?php

include_once 'database_model.php';

class Account_model extends Database_model
{
    public $account;
    
    function __construct()
    {
        
    }
    
    function insert()
    {
        $conn                       =   $this->get_connection();
        
        if ($conn == null)
            return "ERROR:Connection Failed";
        
        if ($stmt = $conn->prepare("INSERT INTO accounts (user_first_name, user_last_name, user_name, password_hash) VALUES (?, ?, ?, ?)"))
        {
            $hash                   =   $this->generate_hash($this->account->password);
            
            if ($stmt->bind_param("ssss", $this->account->user_first_name, $this->account->user_last_name, $this->account->user_name, $hash))
            {
                $exec               =   $stmt->execute();
                $stmt->close();
                $conn->close();
                if (!$exec)
                {
                    return "ERROR:Executing Insert";
                }
            }
            else
            {
                $stmt->close();
                $conn->close();
                return "ERROR:Binding Parameters";
            }
        }
        else
        {
            $conn->close();
            return "ERROR:Preparing Statement";
        }
    }
    
    function validate()
    {
        $errors                     =   $this->account->validate();
        
        return $errors;
    }
    
    function validate_login_form($login_user_name, $login_password)
    {
        $errors                 =   array();
        
        if ($login_user_name == '')
            $errors['login_user_name'] = "User name is required";
            
        if ($login_password == '')
            $errors['login_password'] = "Password is required";
            
            return $errors;
    }
    
    function generate_hash($password)
    {
        $cost                   =   10;
        $salt                   =   strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_RAND)), '+', '.');
        $salt                   =   sprintf("$2a$%02d$", $cost) . $salt;
        $hash                   =   crypt($password, $salt);
        
        return $hash;
    }
    
    function is_valid_login($login_user_name, $login_password)
    {
        $conn                   =   $this->get_connection();
        
        if ($conn == null)
            return "ERROR:Connection Failed";
        
        if ($stmt = $conn->prepare("SELECT password_hash FROM accounts WHERE user_name = ?"))
        {
            if ($stmt->bind_param("s", $login_user_name))
            {
                if($stmt->execute())
                {
                    $stmt->bind_result($db_password);
                    $stmt->fetch();
                    if (isset($db_password) && $db_password == crypt($login_password, $db_password))
                    {
                        return "LOGIN";
                    }
                    else
                    {
                        return "FAILED";
                    }
                }
                else
                {
                    $stmt->close();
                    $conn->close();
                    return "ERROR:Execute";
                }
            }
            else
            {
                $stmt->close();
                $conn->close();
                return "ERROR:Binding Parameters";
            }
        }
        else
        {
            $conn->close();
            return "ERROR:Preparing Statement";
        }
    }
}

class Account
{
    public $user_first_name;
    public $user_last_name;
    public $user_name;
    public $password;
    public $password_re;
    
    function __construct($user_first_name, $user_last_name, $user_name, $password, $password_re)
    {
        $this->user_first_name = $user_first_name;
        $this->user_last_name = $user_last_name;
        $this->user_name = $user_name;
        $this->password = $password;
        $this->password_re = $password_re;
    }
    
    function validate()
    {
        $errors                     =   array();
        
        //first name
        if ($this->user_first_name == '')
        {
            $errors['new_account_first_name'] = 'First Name is required';
        }
        
        //last name
        if ($this->user_last_name == '')
        {
            $errors['new_account_last_name'] = 'Last Name is required';
        }
        
        //user name
        if ($this->user_name == '')
        {
            $errors['new_account_user_name'] = 'User Name is required';
        }
        
        //password
        if ($this->password == '')
        {
            $errors['new_account_password'] = 'Password is required';
        }
        else if ($this->password_re == '')
        {
            $errors['new_account_password_re'] = 'Password Verification is required';
        }
        else if ($this->password != $this->password_re)
        {
            $errors['new_account_password_re'] = 'Password did not match';
        }
        
        return $errors;
    }
}

?>