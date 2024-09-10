<?php
/*
this is logout source code
In this we will delete the cookie 'SessId' and 'encrypt' and 'PHPSESSID'
after that we will redirect the user to the login page
*/
setcookie("SessId", "null", time() - 263000000, "/","student.srechostel.in");
setcookie("auth_session_id", "null", time() - 263000000, "/", "mens-1.srechostel.in");
setcookie("auth_session_id", "null", time() - 263000000, "/", "mens-2.srechostel.in");
setcookie("auth_session_id", "null", time() - 263000000, "/", "women.srechostel.in");
setcookie("PHPSESSID", "null", time() - 263000000, "/", "student.srechostel.in");
setcookie("auth_watch_man", "null", time() - 263000000, "/", "student.srechostel.in");
session_destroy();
sleep(2);
header("Location: /");
