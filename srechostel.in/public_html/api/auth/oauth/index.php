<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../composer/vendor/autoload.php";


// this is testing client id and client secret, change this when push to production.
$oauth = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/../config/oauth/oauth.json");
$oauth = json_decode($oauth, true);
$clientID = $oauth['web']['client_id'];
$clientSecret = $oauth['web']['client_secret'];
$redirectUri = $oauth['web']['redirect_uris'][0];

// Google Client initialization
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

try {
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Retrieve user profile
        $oauth = new Google_Service_Oauth2($client);
        $google_info = $oauth->userinfo->get();
        $email = $google_info->email;
        $name = $google_info->name;
        $email_auth = $google_info['email'];


        // Database connection
        include_once $_SERVER["DOCUMENT_ROOT"] . "/../class-files/mainconn.class.php";
        $conn = new MainConnection();
        $sqlConn = $conn->returnConn();

        $stmt = $sqlConn->prepare("SELECT user_id, who_is FROM login_auth WHERE email_auth=?");
        $stmt->bind_param('s', $email_auth);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Manage session
            include_once $_SERVER["DOCUMENT_ROOT"] . "/../class-files/session.class.php";
            session_destroy();
            session_start();
            $_SESSION["yourToken"] = $row['user_id'];

            $session = new Session($row['user_id'], $row['who_is']);
            if ($session->isSessionExist) {
                // Update session
                $session->updateSession($row['user_id'], RandomString(10));
            } else {
                // Create new session
                $session->createSession($row['user_id'], RandomString(10));
            }
            header("Location: /");
            exit();
        } else {
            // Email not verified case
            showErrorPage("Email not verified", "The email you're trying to login is not verified. Please login with the correct email.", "Login failed");
        }
    } else {
        // Generate Google OAuth URL
        $authUrl = $client->createAuthUrl();
        header("Location: $authUrl");
        exit();
    }
} catch (Exception $e) {
    showErrorPage("Token Expired", "You're trying to log in with the same OAuth token, but the token has expired.", "Login failed");
}

// Function to display error pages
function showErrorPage($title, $message, $header)
{
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php $header ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                --bs-gradient: none;
            }
        </style>
    </head>

    <body>
        <div class="px-4 py-5 my-5 text-center">
            <img class="d-block mx-auto mb-4" src="/images/layout-image/oauth.png" alt="" width="72" height="72">
            <h1 class="display-5 fw-bold text-body-emphasis"><?= $title ?></h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4"><?= $message ?></p>
                <a href="/" class="btn btn-fill-dark btn-lg px-4 gap-3 rounded-1">Go back to login</a>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <?php
    exit();
}



function RandomString($len)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $len; $i++) {
        $randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
?>