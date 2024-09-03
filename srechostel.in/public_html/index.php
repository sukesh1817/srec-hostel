<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/session.class.php";

if (isset($_COOKIE['SessId'])) {
    // check wheather the cookie is exist or not for student or staff.
    $session = new session();
    $result = $session->isSessionPresent($_COOKIE['SessId'], "Staff");
    if ($result) {
        header("Location: /staff-panel");
    }
    $result = $session->isSessionPresent($_COOKIE['SessId'], "Student");
    if ($result) {
        header("Location: /stud-panel");
    }
} else if (isset($_COOKIE['auth_session_id'])) {
   
    $session = new session();
    $result = $session->isSessionPresent($_COOKIE['auth_session_id'], "Admin");

    if ($result == "Mens-1" or $result == "Mens-2" or $result == "Women") {
        $result = strtolower($result);
        header("Location: https://$result.srechostel.in");
    }
   
} else if (isset($_COOKIE['auth_watch_man'])) {
    if ($_COOKIE['auth_watch_man'] == md5(md5("watch-the-man"))) {
        header("Location: /watch-panel");

    } else {
        header("Location: /");
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Srec Hostel Login</title>
    <link rel="icon" type="image/x-icon" href="/images/layout-image/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css-files/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css-files/toggle.css" />
    <style>
        .fas {
            line-height: 3.3;
        }

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
    <section class="bg-light p-3 p-md-4 p-xl-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">
                    <div class="card border-light-subtle shadow-sm">
                        <div class="row g-0">
                            <div class="col-12 col-md-6">
                                <img class="img-fluid rounded-1 w-100 h-100 object-fit-cover" loading="lazy"
                                    src="/images/layout-image/srec.jpg" alt="collage profile">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div class="card-body p-3 p-md-4 p-xl-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-5">
                                                    <h4 class="text-center underlined">Welcome to,<br> Sri Ramakrishana
                                                        Engineering College Hostel</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex gap-3 flex-column">
                                                    <a href="/oauth/" class="btn btn-lg btn-fill-dark rounded-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-google"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                                                        </svg>
                                                        <span class="ms-2 fs-6">Log in with Google</span>
                                                    </a>
                                                </div>
                                                <p class="text-center mt-4 mb-5">or sign in with</p>
                                            </div>
                                        </div>
                                        <form id="log-in-form" method="post">
                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" class="form-control rounded-1"
                                                            name="username" id="username" placeholder="1234" required>
                                                        <label for="username" class="form-label">username</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control" name="password"
                                                            id="password" value="" placeholder="" required>
                                                        <label for="password"
                                                            class="form-label rounded-1">password</label>
                                                        <span class="password-toggle-icon">
                                                            <i id="pass-icon" class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button id="btn-log" class="btn btn-dark btn-lg rounded-1"
                                                        type="submit">
                                                        <span>Login</span>
                                                        <div style="display:none" id="loader"
                                                            class="ms-1 spinner-grow spinner-grow-sm">

                                                        </div>
                                                    </button>

                                                </div>
                                            </div>
                                    </div>
                                    </form>
                                    <div class="row">
                                        <div id="mgsyir" class="col-12">



                                            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                                                <div id="liveToast" class="toast" role="alert" aria-live="assertive"
                                                    aria-atomic="true">
                                                    <div class="toast-header">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor"
                                                            class="bi bi-emoji-expressionless-fill me-2"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M4.5 6h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1m5 0h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1m-5 4h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1" />
                                                        </svg> <strong class="me-auto">Wrong Credentials</strong>
                                                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="toast-body">
                                                        Please Try Again.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/js-files/api/auth/auth.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        const passwordIcon = document.getElementById("pass-icon");
        const passwordField = document.getElementById("password");

        passwordIcon.addEventListener("click", function () {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        });

        $("#password").focus(function () {
            $("#pass-icon").show();
        });

        $("#password").blur(function () {
            if (!$("#password").is(":focus") && !$("#pass-icon").is(":hover")) {
                $("#pass-icon").hide();
            }
        });

        $("#pass-icon").mousedown(function () {
            return false;
        });
    </script>



</body>

</html>