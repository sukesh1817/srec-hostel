<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
?>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";
?>
   <main>

  <div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="/pic/download.png" alt="" width="72" height="57">
    <h1 class="display-5 fw-bold text-body-emphasis">Download your bill information</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Here you can download your accommodation and food orders bill information easily.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <a href="/staff-panel/accommodation/download-bill-info/" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Accommodation</a>
        <a href="/staff-panel/food-booking/download-bill-info/" class="btn btn-outline-secondary btn-lg px-4 rounded-1">Food orders</a>
      </div>
    </div>
  </div>

 
</main> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>