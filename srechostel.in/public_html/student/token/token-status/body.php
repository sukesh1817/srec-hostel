<body>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
  if (
    isset($_SESSION['yourToken'])
  ) {
    //none
  
    /*
    first this code check the token is already booked or not ,
    if booked this show the message token is booked
    */
    if ((date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")) {
      include_once $_SERVER["DOCUMENT_ROOT"] . "/.." . "/class-files/token.class.php";
      $rollNo = isset($_SESSION["yourToken"]) ? $_SESSION["yourToken"] : "1";
      $token = new Token($rollNo);
      $res = $token->isTokenBooked($rollNo);
      if ($res) {
        ?>
        <div class="container-fluid" bis_skin_checked="1">
          <div class="text-center  rounded-3" bis_skin_checked="1">
            <h1 class="text-body-emphasis">Hey
              <?php if (isset($_SESSION['name'])) {
                echo $_SESSION['name'];
              } else {
                echo "Student";
              } ?>
            </h1>
            <p class="col-lg-8 mx-auto fs-5 text-muted">
              Here is you token Information
            </p>
            <?php
            $row = $token->fetchMyToken($_SESSION['yourToken']);
            ?>
            <div class="d-flex flex-column flex-md-row  gap-4  align-items-center justify-content-center"
              bis_skin_checked="1">
              <div
                class="dropdown-menu position-static d-flex flex-column flex-lg-row align-items-stretch justify-content-start p-3 rounded-3 shadow-lg mb-3"
                data-bs-theme="light" bis_skin_checked="1">
                <div class="col-lg-12">
                  <ul class="list-unstyled d-flex flex-column gap-2">
                    <li>
                      <a href="#" class="btn btn-hover-light rounded-2 d-flex align-items-start   text-start">
                        <svg class="bi" width="24" height="24">
                          <use xlink:href="#image-fill"></use>
                        </svg>
                        <div bis_skin_checked="1">
                          <strong class="d-block">Tuesday omlettee - <?php echo $row['tuesday_date'] ?></strong>
                          <small class="text-center">count :
                            <strong><?php echo $row['tuesday_token_count'] ?></strong></small>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#"
                        class="container-fluid btn btn-hover-light rounded-2 d-flex align-items-start  lh-sm text-start">
                        <svg class="bi" width="24" height="24">
                          <use xlink:href="#image-fill"></use>
                        </svg>
                        <div bis_skin_checked="1">
                          <strong class="d-block">Wednesday chicken - <?php echo $row['wednesday_date'] ?></strong>
                          <small class="text-center">count :
                            <strong><?php echo $row['wednesday_token_count'] ?></strong></small>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="btn btn-hover-light rounded-2 d-flex align-items-start  lh-sm text-start ">
                        <svg class="bi" width="24" height="24">
                          <use xlink:href="#image-fill"></use>
                        </svg>
                        <div bis_skin_checked="1">
                          <strong class="d-block">Thursday Egg - <?php echo $row['thursday_date'] ?></strong>
                          <small class="text-center">count :
                            <strong><?php echo $row['thursday_token_count'] ?></strong></small>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="btn btn-hover-light rounded-2 d-flex align-items-start  lh-sm text-start">
                        <svg class="bi" width="24" height="24">
                          <use xlink:href="#image-fill"></use>
                        </svg>
                        <div bis_skin_checked="1">
                          <strong class="d-block">Sunday Chicken - <?php echo $row['sunday_date'] ?></strong>
                          <small class="text-center">count : <strong><?php echo $row['sunday_token_count'] ?></strong></small>

                        </div>
                      </a>
                    </li>
                    <div>
                      <a href="../" class="container-fluid btn btn-dark ">Go back</a>
                      <a href="/stud-panel/token/edit-token/" class="container-fluid btn btn-outline-dark mt-2">Edit token</a>
                    </div>

                  </ul>
                </div>

              </div>
            </div>
          </div>
        </div>

        <?php

      } else {

        ?>
        <div class="container my-5" bis_skin_checked="1">
          <div class="p-4 text-center bg-body-tertiary rounded-3" bis_skin_checked="1">
            <img src="/images/icons/token.png" class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100">
            </img>
            <h1 class="text-body-emphasis">Token yet not booked</h1>
            <button class="btn btn-danger rounded-1 mt-1">
              Please book the token.
            </button>
            <br>
            <a href="../" class="btn btn-secondary rounded-1 mt-2">Go back <span id="count-down"></span></a>

          </div>
        </div>

        <script>
          var elem = document.getElementById('count-down');
          var timer = 5;
          setInterval(function () {
            if (timer == 0) {
              window.location.href = "/stud-panel/token/";
            }
            elem.innerHTML = timer;
            timer--;

          }, 1000);
        </script>
        <!-- <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile"
              viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
              <path
                d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
            </svg> <strong class="me-auto">Token not booked yet</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            Please book before checking status
          </div>
        </div>
      </div>

      <script>
        var show = function () {
          var toastElList = [].slice.call(document.querySelectorAll('.toast'))
          var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl)
          })
          toastList.forEach(toast => toast.show())
        }
        var redir = function () {
          window.location.href = "/stud-panel/token/";
        }
        setTimeout(show, 1000);
        setTimeout(redir, 5000);
      </script> -->
        <?php
      }
    } else {
      ?>
      <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
        <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
        <h1 class="display-5 fw-bold text-body-emphasis">Booking not open</h1>
        <div class="col-lg-6 mx-auto" bis_skin_checked="1">
          <p class="lead mb-4">Please wait sometime to book token.</p>
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
            <a href="../" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Go back <span id="count-down"></span> </a>
          </div>
        </div>
      </div>
      <script>
        var elem = document.getElementById('count-down');
        var timer = 5;
        setInterval(function () {
          if (timer == 0) {
            window.location.href = "/stud-panel/token/";
          }
          elem.innerHTML = timer;
          timer--;

        }, 1000);
      </script>
      <?php
    }
  } else {


    // comes when the session is not set
    ?>

    <div class="toast-container position-fixed bottom-0 end-0 p-3 mb-3">
      <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
          </svg> <strong class="me-auto">Please Login Again</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          Redirecting to login page
        </div>
      </div>
    </div>

    <script>
      var show = function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function (toastEl) {
          return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
      }
      var redir = function () {
        window.location.href = "/logout";
      }
      setTimeout(show, 1000);
      setTimeout(redir, 5000);
    </script>
    <?php
  }

  // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";
  ?>