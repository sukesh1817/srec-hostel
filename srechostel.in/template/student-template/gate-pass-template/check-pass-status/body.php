<body style="background-color: #f8f9fa;">
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/gate-pass-template/check-pass-status/crumbs.php";
  ?>
  <?php
  include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
  $pass = new Pass_class();
  $alreadyBooked = $pass->alreadyBooked($_SESSION["yourToken"]);
  if ($alreadyBooked[0] or $alreadyBooked[1] or $alreadyBooked[2]) {
    $row = [];
    if ($alreadyBooked[0]) {
      $row = $pass->getMyPass("gate_pass");
    } else if ($alreadyBooked[1]) {
      $row = $pass->getMyPass("working_pass");
    } else if ($alreadyBooked[2]) {
      $row = $pass->getMyPass("general_pass");
    }

    ?>
    <div class="container mb-4" bis_skin_checked="1">
      <div class="position-relative  text-center text-muted bg-body border border-dashed rounded-2" bis_skin_checked="1">

        <svg class="bi mb-3" width="48" height="48">
          <use xlink:href="#check2-circle"></use>
        </svg>
        <h1 class="text-body-emphasis">Pass Information</h1>
        <hr>
        <p class="col-lg-6 mx-auto mb-4">

          <?php
          echo "Name : <strong>" . $row['stud_name'] . '</strong><br>';
          echo "Roll no : <strong> " . $row['roll_no'] . '</strong><br>';
          echo "Department : <strong> " . $row['department'] . '</strong><br>';
          echo "From : <strong>" . $row['time_of_leave'] . '</strong><br>';
          echo "To : <strong>" . $row['time_of_entry'] . '</strong><br>';
          echo "Address : <strong> " . $row['address_name'] . '</strong><br>';

          ?>
        </p>
        <?php
        
        if ($pass->isPassAccepted("gate_pass") or $pass->isPassAccepted("working_day_pass") or $pass->isPassAccepted("general_home_pass")) {
          ?>
          
          <?php
        } else {
            ?>
            <a href="/stud-panel/gate-pass/edit-gate-pass/" class="btn btn-dark px-5 mb-5 rounded-1" type="button">
            Want To Change something
          </a>
            <?php
        }
        ?>

      </div>
    </div>
    <?php

  } else {
    ?>
    <main>
      <div class="container-fluid" bis_skin_checked="1">
        <div class="border-bottom"></div>
        <div class="p-5  mb-4 bg-body-tertiary rounded-1" bis_skin_checked="1">
          <div class="container-fluid py-5" bis_skin_checked="1">
            <h1 class="display-5 fw-bold">Gate pass not booked</h1>
            <p class="col-md-8 fs-4">Please book the gate pass to check the status of the gate pass.</p>
            <a href="/stud-panel/gate-pass/book-gate-pass" class="btn btn-dark btn-lg rounded-1">book gate pass <span
                id="count-down"> </span></a>
          </div>
        </div>

        <!-- <div class="row align-items-md-stretch" bis_skin_checked="1">
          <div class="col-md-6" bis_skin_checked="1">
            <div class="h-100 p-5 text-bg-dark rounded-1" bis_skin_checked="1">
              <h2>Change the background</h2>
              <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then,
                mix and match with additional component themes and more.</p>
              <button class="btn btn-outline-light" type="button">Example button</button>
            </div>
          </div>
          <div class="col-md-6" bis_skin_checked="1">
            <div class="h-100 p-5 bg-body-tertiary border rounded-1" bis_skin_checked="1">
              <h2>Add borders</h2>
              <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure
                to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's
                content for equal-height.</p>
              <button class="btn btn-outline-secondary" type="button">Example button</button>
            </div>
          </div>
        </div> -->
      </div>
    </main>
    <script>
      var elem = document.getElementById('count-down');
      var timer = 5;
      setInterval(function () {
        if (timer == 0) {

          window.location.href = "/stud-panel/gate-pass/book-gate-pass";
        }
        elem.innerHTML = timer;
        timer--;

      }, 1000);
    </script>
    <?php
  }
  ?>

  <?php
  // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";
  
  ?>
</body>