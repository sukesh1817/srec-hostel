<?php
include_once ($_SERVER["DOCUMENT_ROOT"]. "/is-staff.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order status</title>
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.3/examples/product/product.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
?>
<style>
    .table tbody tr + tr {
      margin-top: 15px; /* Adjust this value as needed */
    }
    .table tbody tr {
      display: flex;
    }
    .table tbody td {
      flex: 1;
    }
    tr{
        background-color:#f8f9fa;
    }
  </style>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/staff-template/common-template/navbar.php";
?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
    <div class="col-md-6 p-lg-5 mx-auto my-5 mb-5">
      <h1 class="display-3 fw-bold">Check your orders</h1>
      <h3 class="fw-normal text-muted mb-3">Scroll to check the food and accommodation orders</h3>
      <div class="d-flex gap-3 justify-content-center lead fw-normal">
        <a class="btn btn-dark rounded-1 btn-lg" href="#orders">
          Check orders
        </a>
       
      </div>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
  </div>
  <div id="orders" class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
    <div class="text-bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
      <div class="my-3 py-3">
        <h2 class="display-5">Accommodation Orders</h2>
        <p class="lead">And an even wittier subheading.</p>
      </div>
      <div class="d-flex bg-body-tertiary shadow-sm mx-auto text-dark" style="width: 80%; height: 300px; border-radius: 5px 5px 0 0;">
       <?php
        // if accommodation is booked then show accommodation status else give 'no orders booked' message
        include_once ($_SERVER["DOCUMENT_ROOT"] . "/../class-files/accommodation.class.php");
        $accom = new accommodation();
        $status = $accom->checkAccomStatus($_SESSION['yourToken']);
        
        if($status!="none"){
          $row = [];
          if($status=="accepted"){
            $row = $accom->getMyData($_SESSION['yourToken']);
            ?>
            <div class="container mt-3">
                    <button class="btn btn-success rounded-1 mb-1">Your order is accepted</button>
                    <?php
                    //print_r($row);c
                    ?>
                    <table class="bg-body-tertiary table table-sm mt-3 ">
                        <thead class="thead-light">
      <tr>
        <th colspan="2" scope="col">Accomodation details</th>
      </tr>
    </thead>
    <tbody class="bg-body-tertiary">
      <tr class="mt-3">
        <td class="fw-bold">Check in date</td>
        <td><?php echo $row['accom_check_in_date']; ?></td>
      </tr>
      <tr class="mt-1">
        <td class="fw-bold">Check out date</td>
        <td><?php echo $row['accom_check_out_date']; ?></td>
      </tr>
      <tr class="mt-1">
        <td class="fw-bold">No of members</td>
        <td><?php echo ($row['no_of_male_student']+$row['no_of_female_student']+$row['no_of_male_staff']+$row['no_of_female_staff']); ?> Peoples</td>
      </tr>
      <tr class="mt-1">
        <td class="fw-bold">No of Rooms</td>
        <td><?php echo ($row['no_of_male_student_room']+$row['no_of_female_student_room']+$row['no_of_male_staff_room']+$row['no_of_female_staff_room']); ?> Rooms</td>
      </tr>
    </tbody>
  </table>

                    
            </div>
            <?php
          } else if($status=="pending"){
            $row = $accom->getMyPendingData($_SESSION['yourToken']);
          }else {
            $row = $accom->getMyDeclinedData($_SESSION['yourToken']);
          }
          
          
        } else {
          ?>

          <?php
        }
       ?>
       
      </div>
    </div>
    <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
      <div class="my-3 p-3">
        <h2 class="display-5">Food <br> Orders</h2>
        <p class="lead">And an even wittier subheading.</p>
      </div>
      <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 5px 5px 0 0;"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>