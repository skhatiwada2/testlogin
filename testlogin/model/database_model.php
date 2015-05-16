<?php

include_once 'config/db_config.php';

class Database_model
{
    function get_connection()
    {
        $conn = new mysqli(SERVER_NAME, USER_NAME, USER_PASS, DB_NAME);
        
        if ($conn->connect_error)
            $conn = null;
            
        return $conn;
    }
}

?>