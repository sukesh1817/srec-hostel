<?php
/*
This file helps to check wheather the person is watch man
if the person is watch man allow them
else do not allow 
*/
if(isset($_COOKIE["auth_watch_man"])) {
    if($_COOKIE["auth_watch_man"]==md5(md5("watch-the-man"))) {
        if(isset($_SESSION["yourToken"])) {
            
        } else {
            session_start();
            $_SESSION["yourToken"]=md5(md5("watch-the-man")) ;
        }
    } else {
        header("Location: /");
}

} else {
    header("Location: /");
}

