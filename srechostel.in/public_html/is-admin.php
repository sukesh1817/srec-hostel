<?php
/*
This file helps to check wheather the person is admin 
if the person is admin allow them
else do not allow 
*/
if(isset($_COOKIE["auth_user"])) {
    if($_COOKIE["auth_user"]==md5("auth_user")) {
        if(isset($_SESSION["yourToken"])) {
            
        } else {
            session_start();
            $_SESSION["yourToken"]=md5("auth_user") ;
        }
    } else {
        header("Location: /");
       
}

} else {
    header("Location: /");
}

