<?php
if (isset($_REQUEST["username"]) and isset($_REQUEST["password"])) {
  session_start();
  include_once($_SERVER["DOCUMENT_ROOT"] . "/.." . "/class-files/login.class.php");
  include_once($_SERVER["DOCUMENT_ROOT"] . "/.." . "/class-files/session.class.php");
  $userName = trim($_REQUEST["username"]);
  $passWord = trim($_REQUEST["password"]);


  if (!preg_match('/^[0-9]+$/', $userName)) {
    echo "username is something suspicious";
    exit; // Stop execution if validation fails
  }

  // Validation for password: should contain at least one numeric and one special character
  if (!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{6,15}$/', $passWord)) {
    echo "password is something suspicious";
    exit; // Stop execution if validation fails

  }
  $finalRes = login::loginAuth($userName, $passWord);

  $json = json_decode($finalRes, false);

  $status_value = [];
  foreach ($json as $value) {
    array_push($status_value, $value);
  }

  if ($status_value[0] == "success" and ($status_value[1] == "Student" or $status_value[1] == "Staff")) {
    session_destroy();
    session_start();
    $_SESSION["yourToken"] = $userName;
    $session = new session($userName, $status_value[1]);
    if ($session->isSessionExist) {
      /* 
      if the session is already present then just update the session
      */
      $result = $session->updateSession($userName, $passWord);
    } else {
      /* 
      else create new session for the user 
      */
      $result = $session->createSession($userName, $passWord);
    }
  } else if ($status_value[0] == "success" and ($status_value[1] == 'Mens-1' or $status_value[1] == "Mens-2" or $status_value[1] == "Women")) {
    session_destroy();
    session_start();
    $_SESSION["yourToken"] = $userName;
    $session = new session($userName, $status_value[1]);
    if ($session->isSessionExist) {
      /* 
      if the session is already present then just update the session 
      */
      $result = $session->updateSession($userName, $passWord);
    } else {
      /* 
      else create new session for the user 
      */
      $result = $session->createSession($userName, $passWord);
    }
  } else if ($status_value[1] == 'watch-man' and $status_value[0] == "success") {
    $_SESSION["yourToken"] = $userName;
    $sessionId = md5(md5("watch-the-man"));
    setcookie("auth_watch_man", $sessionId, time() + 2630000, "/");
  } else {
    // http_response_code(401);
  }
  echo $status_value[0];
} else {
  // respond to bad request using the php file .
  header("Content-Type: application/json");
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../php-modules/authorization/bad-request.php";
}

