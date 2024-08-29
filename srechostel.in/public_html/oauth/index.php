<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../composer/vendor/autoload.php";

$clientID = '182833141792-0dfcvk86f4hv9l5e7p01eeuj5ac5hd15.apps.googleusercontent.com';
$clientSecret = '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';
$ip = $_SERVER['REMOTE_ADDR'];
$redirectUri = "https://srechostel.in/oauth/";

// Creating client request to google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  try{
  $client->setAccessToken($token);
  }
  catch(Exception $e){
      ?>
      <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .btn-fill-dark {
            --bs-btn-color: #212529;
            --bs-btn-border-color: #212529;
            --bs-btn-hover-color: #212529;
            --bs-btn-hover-border-color: #212529;
            --bs-btn-focus-shadow-rgb: 33, 37, 41;
            --bs-btn-active-color: #212529;
            --bs-btn-active-border-color: #212529;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #212529;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #212529;
            --bs-gradient: none
        }

       
       
    </style>
</head>

<body>
    <div class="px-4 py-5 my-5 text-center">
        <img class="d-block mx-auto mb-4" src="/images/layout-image/oauth.png" alt="" width="72" height="72">
        <h1 class="display-5 fw-bold text-body-emphasis">Token Expired</h1>
        <div class="col-lg-6 mx-auto">
          <p class="lead mb-4">you're trying to login with same oauth token , but the token is expired.</p>
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="/" class="btn btn-fill-dark btn-lg px-4 gap-3 rounded-1">Go back to login</a>
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
      <?php
            exit;

  }
  // Getting User Profile
  $oauth = new Google_Service_Oauth2($client);
  $google_info = $oauth->userinfo->get();
  $email = $google_info->email;
  $name = $google_info->name;
  $email_auth = $google_info['email'];
  include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";
  $conn = new Connection();
  $sqlConn = $conn->returnConn();
  $sqlQuery = "SELECT user_id,who_is FROM login_auth WHERE email_auth='$email_auth';";
  $result = $sqlConn->query($sqlQuery);
  if ($result) {
    $row = $result->fetch_assoc();
    if (isset($row['user_id'])) {
      include_once ($_SERVER["DOCUMENT_ROOT"] . "/.." . "/class-files/session.class.php");
      session_destroy();
      session_start();
      $_SESSION["yourToken"] = $row['user_id'];
      $session = new session( $row['user_id'], $row['who_is']);
      if ($session->isSessionExist) {
        /* 
        if the session is already present then just update the session
        */
        $result = $session->updateSession($row['user_id'],"Srec@123");
        header("Location: /");
      } else {
        /* 
        else create new session for the user 
        */
        $result = $session->createSession($row['user_id'],"Srec@123");
        header("Location: /");
      }
    } else {
      ?>
      <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .btn-fill-dark {
            --bs-btn-color: #212529;
            --bs-btn-border-color: #212529;
            --bs-btn-hover-color: #212529;
            --bs-btn-hover-border-color: #212529;
            --bs-btn-focus-shadow-rgb: 33, 37, 41;
            --bs-btn-active-color: #212529;
            --bs-btn-active-border-color: #212529;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #212529;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #212529;
            --bs-gradient: none
        }

       
       
    </style>
</head>

<body>
    <div class="px-4 py-5 my-5 text-center">
        <img class="d-block mx-auto mb-4" src="/images/layout-image/oauth.png" alt="" width="72" height="72">
        <h1 class="display-5 fw-bold text-body-emphasis">Email not verified</h1>
        <div class="col-lg-6 mx-auto">
          <p class="lead mb-4">The email you're trying to login is not verified please login with the collage email.</p>
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="/" class="btn btn-fill-dark btn-lg px-4 gap-3 rounded-1">Go back to login</a>
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
      <?php

    }
  } else {
    //someting went wrong
  }
} else {
  $url = $client->createAuthUrl();
  header("Location: $url");
  // echo "<a href='".$client->createAuthUrl()."'>Login with Google</a>";
}
?>