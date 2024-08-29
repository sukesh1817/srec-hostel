<body>
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
  ?>

  <div class="p-5 mt-5  bg-body-tertiary rounded-3" bis_skin_checked="1">
    <div class="container-fluid py-5" bis_skin_checked="1">
      <h1 class="display-5 fw-bold py-1">Hey <br> <span class="fs-1">
        <?php if (isset($_SESSION['name'])) {
          echo $_SESSION['name'];
        } else {
          echo "Student";
        } ?>
        <span></h1>
      <p class="lead">Welcome to the your dashboard! We're excited to have you here and ready to explore it.</p>
      <a href='#token' class="btn btn-dark btn-lg px-4 me-md-2 rounded-1" type="button">Explore the things</a>
    </div>
  </div>

  <div class="px-4 py-5 my-5 text-center" bis_skin_checked="1">
    <img class="d-block mx-auto mb-4" src="/images/layout-image/gate.png" alt="" width="72" height="57">
    <h1 class="display-5 fw-bold text-body-emphasis">Book Gate Pass</h1>
    <div class="col-lg-6 mx-auto" bis_skin_checked="1">
      <p class="lead">Welcome to the gate pass booking section of our website! Please follow the instructions to book
        your gate pass seamlessly.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-lg-center justify-content-md-start" bis_skin_checked="1">
        <a href="gate-pass/" type="button" class="btn btn-outline-dark btn-lg px-4 me-md-2 rounded-1">Book gatepass</a>
      </div>
    </div>
  </div>

  <div id='token' class="container-fluid bg-body-secondary">
    <div class="container col-xxl-8 px-4 py-5" bis_skin_checked="1">
      <div class="row flex-lg-row-reverse align-items-center g-5 py-5" bis_skin_checked="1">
        <div class="col-10 col-sm-8 col-lg-6 d-flex" bis_skin_checked="1">
          <img src="/images/layout-image/restaurant.png"
            class="d-block mx-lg-5 img-fluid rounded-1 align-items-center justify-content-center" alt="Bootstrap Themes"
            loading="lazy" width="100" height="100">
        </div>
        <div class="col-lg-6" bis_skin_checked="1">
          <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Book Food Token</h1>
          <p class="lead">By clicking the below button you book your food token and also you can the pervious booking
            information of the token.</p>
          <div class="d-grid gap-2 d-md-flex justify-content-md-start" bis_skin_checked="1">
            <a href="/stud-panel/token/" class="btn btn-dark btn-lg px-4 me-md-2 rounded-1">Book food</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5" bis_skin_checked="1">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg" bis_skin_checked="1">
      <div class="col-lg-7 p-3 p-lg-5 pt-lg-3" bis_skin_checked="1">
        <h1 class="display-4 fw-bold lh-1 text-body-emphasis">Any Problem Within the collage hostel rooms ?</h1>
        <p class="lead">You can book your complaint through the complaint form , it contains personal and common
          complaint , you can book it, after the our hostel team will contact you soon.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3" bis_skin_checked="1">
          <a href="/stud-panel/complaint/book-common-complaint/" class="btn btn-dark btn-lg px-4 me-md-2 fw-bold rounded-1">Common</a>
          <a href="/stud-panel/complaint/book-individual-complaint/"
            class="btn btn-outline-secondary btn-lg px-4 rounded-1">Personal</a>
        </div>
      </div>
      <div class="d-flex justify-content-center align-items-center col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg"
        bis_skin_checked="1">
        <img class="img-fluid rounded-1" src="/images/layout-image/complaint.jpg" alt="" width="720">
      </div>
    </div>
  </div>
<?php
  include_once $_SERVER['DOCUMENT_ROOT']. "/../template/student-template/common-template/footbar.php";
?>

</body>