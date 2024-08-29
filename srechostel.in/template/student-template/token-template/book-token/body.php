<body>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";

  /*
  first this code check the token is already booked or not ,
  if booked this show the message token is booked
  */
  if (isset($_SESSION['yourToken'])) {
    if ((date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")) {

    include_once $_SERVER["DOCUMENT_ROOT"] . "/.." . "/class-files/token.class.php";
    $rollNo = isset($_SESSION["yourToken"]) ? $_SESSION["yourToken"] : "1";
    $token = new Token($rollNo);
    $res = $token->isTokenBooked($rollNo);
    if ($res) {
      ?>
        <div class="container my-5" bis_skin_checked="1">
    <div class="p-4 text-center bg-body-tertiary rounded-3" bis_skin_checked="1">
      <svg class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100">
        <use xlink:href="#bootstrap"></use>
      </svg>
      <h1 class="text-body-emphasis">Hey Welcome
        <?php if (isset($_SESSION['name'])) {
          echo $_SESSION['name'];
        } else {
          echo "Student";
        } ?> </h1>
      <p class="col-lg-8 mx-auto fs-5 text-muted">
       Token already Booked Enjoy your meal!
      </p>
      
    </div>
  </div>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile"
                  viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                  <path
                    d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
                </svg> <strong class="me-auto">Token already booked</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
               Enjoy your meal !
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
            setTimeout(show, 2000);
            setTimeout(redir, 4000);
          </script>
      <?php

    } else {
      if (
        isset($_SESSION["yourToken"])
        and isset($_POST["tuesdayCount"])
        and isset($_POST["wednesdayCount"])
        and isset($_POST["thursdayCount"])
        and isset($_POST["sundayCount"])
        and (date("l") == "Tuesday" or date("l") == "Wednesday" or date("l") == "Thursday" or date("l") == "Friday" or date("l") == "Saturday")
      ) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/.." . "/class-files/token.class.php";
        $conn = new Connection();
        $result = false;
        $sqlConn = $conn->returnConn();
        $tuesday = $_POST["tuesdayCount"];
        $wednesday = $_POST["wednesdayCount"];
        $thursday = $_POST["thursdayCount"];
        $sunday = $_POST["sundayCount"];
        $rollNo = $_SESSION["yourToken"];
        $day = date("l");
        $nextTuesday = "";
        if ($day == "Tuesday") {
          $date = strtotime("+7 day", strtotime(date("Y-m-d")));
          $nextTuesday = date("Y-m-d", $date);
        } else if ($day == "Wednesday") {
          $date = strtotime("+6 day", strtotime(date("Y-m-d")));
          $nextTuesday = date("Y-m-d", $date);
        } else if ($day == "Thursday") {
          $date = strtotime("+5 day", strtotime(date("Y-m-d")));
          $nextTuesday = date("Y-m-d", $date);
        } else if ($day == "Friday") {
          ;
          $date = strtotime("+4 day", strtotime(date("Y-m-d")));
          $nextTuesday = date("Y-m-d", $date);
        } else if ($day == "Saturday") {
          ;
          $date = strtotime("+3 day", strtotime(date("Y-m-d")));
          $nextTuesday = date("Y-m-d", $date);
        }

        $date = strtotime("+1 day", strtotime($nextTuesday));
        $nextWednesday = date("Y-m-d", $date);

        $date = strtotime("+1 day", strtotime($nextWednesday));
        $nextThursday = date("Y-m-d", $date);

        $date = strtotime("+3 day", strtotime($nextThursday));
        $nextSunday = date("Y-m-d", $date);

        // }
        $array = array(
          "rollNo" => $rollNo,

          "tuesdayCount" => $tuesday,
          "tuesdayDate" => $nextTuesday,

          "wednesdayCount" => $wednesday,
          "wednesdayDate" => $nextWednesday,

          "thursdayCount" => $thursday,
          "thursdayDate" => $nextThursday,

          "sundayCount" => $sunday,
          "sundayDate" => $nextSunday

        );
        $token = new Token($rollNo);
        if ($token->isTokenIdPresent) {
          $result = $token->updateToken($array);

        } else {
          $result = $token->createNewToken($array);
        }
        if ($result) {
          ?>
          <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
    <img class="d-block mx-auto mb-4" src="/images/layout-image/restaurant.png" alt="" width="72" height="57">
    <h1 class="display-5 fw-bold text-body-emphasis">Token booked Successfully</h1>
    <div class="col-lg-6 mx-auto" bis_skin_checked="1">
      <p class="lead mb-4">Enjoy your meal.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" bis_skin_checked="1">
        <a href="../" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Go back <span id="count-down"></span> </a>
      </div>
    </div>
  </div>
          <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile"
                  viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                  <path
                    d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
                </svg> <strong class="me-auto">Token booked Successfully</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
                Enjoy your meal
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
            setTimeout(redir, 3000);
          </script>
          <?php


        } else {
          ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile"
                  viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                  <path
                    d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
                </svg> <strong class="me-auto">Token Booked Failed</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
                Something went wrong
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
            setTimeout(redir, 3000);
          </script>
          <?php
        }

      } else {
        ?>

<form class="mx-200 mx-2" action="/stud-panel/token/book-token/" method="post">
    <h5 class="text-center display-6 mt-4 mb-3 fw-bold">Book token for next week</h5>
    <hr>
    <div
      class="container card my-5 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
      bis_skin_checked="1">
      <p class="text-s">1.Tuesday omelette count</p>


      <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
        <input class="list-group-item-check pe-none" type="radio" name="tuesdayCount" id="1" value="1">
        <label class="list-group-item rounded-3 py-2" for="1">
          1
        </label>

       

        <input class="list-group-item-check pe-none" type="radio" name="tuesdayCount" id="3" value="0">
        <label class="list-group-item rounded-3 py-2" for="3">
          skip
        </label>
      </div>
    </div>


    <div
      class="container card  my-5 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
      bis_skin_checked="1">
      <p>2.Wednesday chicken count</p>

      <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
        <input class="list-group-item-check pe-none" type="radio" name="wednesdayCount" id="4" value="1">
        <label class="list-group-item rounded-3 py-2" for="4">
          1
        </label>
        
         <input class="list-group-item-check pe-none" type="radio" name="wednesdayCount" id="5" value="2">
        <label class="list-group-item rounded-3 py-2" for="5">
          2
        </label>

       
        <input class="list-group-item-check pe-none" type="radio" name="wednesdayCount" id="6" value="0">
        <label class="list-group-item rounded-3 py-2" for="6">
          skip
        </label>


      </div>
    </div>
    <div
      class="container card  my-5 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
      bis_skin_checked="1">
      <p>3.Thursday egg count</p>

      <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
        <input class="list-group-item-check pe-none" type="radio" name="thursdayCount" id="7" value="1">
        <label class="list-group-item rounded-3 py-2" for="7">
          1
        </label>
        
         <input class="list-group-item-check pe-none" type="radio" name="thursdayCount" id="8" value="2">
        <label class="list-group-item rounded-3 py-2" for="8">
          2
        </label>

       

        <input class="list-group-item-check pe-none" type="radio" name="thursdayCount" id="9" value="0">
        <label class="list-group-item rounded-3 py-2" for="9">
          skip
        </label>


      </div>
    </div>



    <div
      class=" container card  my-3 d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center"
      bis_skin_checked="1">
      <p>4.Sunday chicken count</p>

      <div class="list-group list-group-checkable d-grid gap-2 border-0" bis_skin_checked="1">
        <input class="list-group-item-check pe-none" type="radio" name="sundayCount" id="10" value="1">
        <label class="list-group-item rounded-3 py-2" for="10">
          1
        </label>
        
         <input class="list-group-item-check pe-none" type="radio" name="sundayCount" id="11" value="2">
        <label class="list-group-item rounded-3 py-2" for="11">
          2
        </label>

       

        <input class="list-group-item-check pe-none" type="radio" name="sundayCount" id="12" value="0">
        <label class="list-group-item rounded-3 py-2" for="12">
          skip
        </label>


      </div>
    </div>
    <div class="d-flex justify-content-center my-2">
      <button class="container-md btn btn-dark btn-lg rounded-1 ">submit</button>



    </div>
  </form>
        <?php
      }
    }
  }  else {
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
    setInterval(function(){
      if(timer==0){
        window.location.href="/stud-panel/token/";
      }
      elem.innerHTML = timer;
      timer--;
     
    },1000);
  </script>
    <?php
  }
}else {
    // comes when the session is not set
    ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
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
              window.location.href = "/stud-panel/token/";
            }
            setTimeout(show, 1000);
            setTimeout(redir, 5000);
          </script>
    <?php
  }
  // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";

  ?>
