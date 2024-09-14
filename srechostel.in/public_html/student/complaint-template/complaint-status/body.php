<body >
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
  ?>
  <?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
$complaint = new commonClass();
$which_is_booked = $complaint->alreadyBooked($_SESSION['yourToken']);

  if ($which_is_booked) {
   
   $row=[];
    if($which_is_booked==1){
      $row=$complaint->retriveMyComplaint("common_complaint");
    } else {
      $row=$complaint->retriveMyComplaint("individual_complaint");

    }

    ?>
    <div class="container mt-5" bis_skin_checked="1">
      <div class="position-relative  text-center text-muted bg-body border border-dashed rounded-1 mx-2" bis_skin_checked="1">

        <svg class="bi mb-3" width="48" height="48">
          <use xlink:href="#check2-circle"></use>
        </svg>
        <h1 class="text-body-emphasis">Complaint Information</h1>
        <h2 class="text-body-emphasis"><?php if($which_is_booked==1){echo "Common complaint";}else{ echo"Individual complaint";} ?></h2>
        <hr>
        <div class="col-lg-6 mx-auto mb-4 container">

          <?php
          if($which_is_booked==1) {
            echo "<p>Department : <strong>" . $row['department'] . '</strong></p>';
            echo "<p>Date of complaint: <strong> " . $row['date_of_complaint'] . '</strong></p>';
            echo "<p>complaint summary : <strong> " . $row['complaint_summary'] . '</strong></p>';
           
          } else {
            echo "<p>Name : <strong>" . $row['stud_name'] . '</strong></p>';
            echo "<p>Roll no : <strong>" . $row['roll_no'] . '</strong></p>';
            echo "<p>Room no : <strong>" . $row['room_no'] . '</strong></p>';
            echo "<p>Department : <strong>" . $row['department'] . '</strong>';
            echo "<p>Date of complaint: <strong> " . $row['date_of_complaint'] . '</strong></p>';
            echo "<p>complaint summary : <strong> " . $row['complaint_summary'] . '</strong></p>';
          }
         

          ?>
        </div>
        <a href="/stud-panel/complaint/edit-complaint/" class="btn btn-dark px-5 mb-5 rounded-1" type="button">
          Change something
        </a>
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
            <h1 class="display-5 fw-bold">Complaint not booked</h1>
            <p class="col-md-8 fs-4">Please book the Complaint after check the status of the complaint.</p>
            <a href="/stud-panel/complaint" class="btn btn-dark btn-lg rounded-1">book complaint <span id="count-down"> </span></a>
          </div>
        </div>
    </main>
    <script>
    var elem = document.getElementById('count-down');
    var timer = 5;
    setInterval(function(){
      if(timer==0){
        
        window.location.href="/stud-panel/complaint/";
      }
      elem.innerHTML = timer;
      timer--;
     
    },1000);
  </script>
    <?php
  }
  ?>

  <?php
  // include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/footbar.php";

  ?>
</body>