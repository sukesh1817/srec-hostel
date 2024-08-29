<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-stud.php";
echo "sample";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bus Pass</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-orange {
      --bs-btn-color: #fff;
      --bs-btn-bg: #eb901a;
      --bs-btn-border-color: #eb901a;
      --bs-btn-hover-color: #fff;
      --bs-btn-hover-bg: #e99c38;
      --bs-btn-hover-border-color: #eb901a;
      --bs-btn-focus-shadow-rgb: 49, 132, 253;
      --bs-btn-active-color: #fff;
      --bs-btn-active-bg: #eb901a;
      --bs-btn-active-border-color: #eb901a;
      --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
      --bs-btn-disabled-color: #fff;
      --bs-btn-disabled-bg: #eb901a;
      --bs-btn-disabled-border-color: #eb901a
    }
  </style>
</head>

<body>


  <?php

  if (isset($_SESSION["yourToken"])) {
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/bus.class.php");
    $busPass = new Bus();
    $alreadyBooked = $busPass->isPassBooked($_SESSION["yourToken"]);
    if ($alreadyBooked) {
      
      ?>
      <div class="p-5 m-3 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-5 mb-2 fw-bold">Bus Pass Already Booked</h1>
          <p class="col-md-8 fs-4">Please Check It :)</p>
          <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
        </div>
      </div>
      <?php
    } else if (isset($_POST["destination"]) and isset($_POST["bookedDate"])) {
      include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/common.class.php");
      $common = new commonClass();
      $studDetails = $common->getStudDetails($_SESSION["yourToken"]);
      $data = array(
        "name" => $studDetails["name"],
        "rollno" => $studDetails["roll_no"],
        "destination" => $_POST["destination"],
        "bookdate" => $_POST["bookedDate"]
      );
      $result = $busPass->insertPass($data);
      if ($result) {
        ?>
          <div class="p-5 m-3 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
              <h1 class="display-5 mb-2 fw-bold">Bus Pass Booked Successfully</h1>
              <p class="col-md-8 fs-4">Enjoy Your Journey :)</p>
              <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
            </div>
          </div>
        <?php
      } else {
        ?>
          <div class="p-5 m-3 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
              <h1 class="display-5 mb-2 fw-bold">Bus Pass Booked Failed</h1>
              <p class="col-md-8 fs-4">Something Went Wrong :(</p>
              <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
            </div>
          </div>
        <?php
      }
    } else {
     

      include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");
      $pass = new Pass_class();
      $result = $pass->alreadyBooked($_SESSION["yourToken"]);
      if($result[2]){ //check wheather the home pass is booked
       
        ?>
<style>
        body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          background-color: #f0f0f0;
        }

        .bus-pass {
          background-color: #fff;
          border-radius: 10px;
          padding: 20px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          max-width: 290px;
        }

        .bus-pass h1 {
          text-align: center;
        }

        .pass-details {
          margin-top: 20px;
        }

        .pass-info {
          margin-bottom: 10px;
        }

        .pass-info label {
          display: inline-block;
          width: 100px;
        }

        .pass-info input[type="text"],
        .pass-info input[type="date"],
        .pass-info input[type="number"] {
          width: calc(100% - 120px);
          padding: 7px;
          border-radius: 5px;
          border: 1px solid #ccc;
        }
     
      </style>
      <form action="../busPass/" method="POST">
        <div class="bus-pass">
          <h1>Bus Pass</h1>
          <hr>
          <div class="pass-details">
            <div class="pass-info">
              <label for="Destination">Destination</label>
              <input type="text" name="destination" list="places">
              <datalist id="places">
                <option value="Singanalur">Singanalur</option>
                <option value="Gandhipuram">Gandhipuram</option>
                <option value="Annur">Annur</option>
                <option value="Maruthamalai">Maruthamalai</option>
                <option value="Mettupalayam">Mettupalayam</option>
              </datalist>
            </div>
            <div class="pass-info">
              <label for="date">Date</label>
              <input type="date" id="date" name="bookedDate">
            </div>
          </div>
          <div class="d-flex">
            <button class="container-fluid btn btn-orange justify-content-center" type="submit">Request Pass</button>

          </div>

        </div>
      </form>
        <?php
      } else {
        
        ?>
 <div class="p-5 m-3 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 mb-2 fw-bold">Home Pass Not Booked Yet</h1>
        <p class="col-md-8 fs-4">Please Book It</p>
        <a href="../" class="btn btn-orange btn-lg text-white" type="button">Go Back</a>
      </div>
    </div>
        <?php
      }

      } 
   
  } else {
    ?>
    <div class="p-5 m-3 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 mb-2 fw-bold">Something Went Wrong</h1>
        <p class="col-md-8 fs-4">Please Login Again :(</p>
        <a href="../../" class="btn btn-orange btn-lg text-white" type="button">Login Page</a>
      </div>
    </div>
    <?php
  }
  ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>