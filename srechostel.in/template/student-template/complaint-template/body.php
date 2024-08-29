<body>
<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/student-template/common-template/navbar.php";
  ?>

<div class="container my-5">
  <div class="p-5 text-center bg-body-tertiary rounded-3">
    <img src="/images/layout-image/bad-review.png" alt="" width="50" height="50">
    <!-- <svg class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="100" height="100"><use xlink:href="#bootstrap"></use></svg> -->
    <h1 class="text-body-emphasis">Register your complaint</h1>
    <p class="col-lg-8 mx-auto fs-5 text-muted">
      Here you can register throught the register form and also you can see the status of your registration
    </p>
    <div class="d-inline-flex gap-2 mb-5">
      <a href="/stud-panel/complaint/book-common-complaint/" class=" btn btn-dark  rounded-1" >
        common 
      </a>
      <a href="/stud-panel/complaint/book-individual-complaint/" class="btn btn-outline-dark  rounded-1" >
        Individual 
      </a>
    </div>
  </div>
</div>
<section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">See your status</h1>
        <p class="lead text-body-secondary">Here you can see your staus of your complaint and also you can able to edit if you are booked your comaplint.</p>
        <p>
          <a href="/stud-panel/complaint/complaint-status" class="btn btn-secondary my-2 rounded-1">status of complaint</a>
          <a href="/stud-panel/complaint/edit-complaint" class="btn btn-dark my-2 rounded-1">edit the complaint</a>
        </p>
      </div>
    </div>
  </section>

  <?php
  // include_once $_SERVER['DOCUMENT_ROOT']. "/../template/student-template/common-template/footbar.php";
?>
</body>