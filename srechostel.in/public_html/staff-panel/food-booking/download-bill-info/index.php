<?php


include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-staff.php";
?>

<?php
if (isset($_SESSION["yourToken"])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/food.class.php";
    // echo $_SESSION['yourToken'];
    $food = new Food_class();
    if ($food->isFoodBooked($_SESSION['yourToken'])) {
    } else {
        echo "Food orders not booked";
        exit;
    }
    include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $staffId = $_SESSION['yourToken'];
    $sqlQuery = "SELECT * FROM `event_food` WHERE staff_id='$staffId' ;";
    $result = $sqlConn->query($sqlQuery);
    $row = $result->fetch_assoc();
    if ($result) {
        if (isset($row['event_date'])) {
            // $pdfname = $_SESSION['yourToken']."-".$row['event_date'] . ".pdf";
            // chdir($_SERVER['DOCUMENT_ROOT'] . "/../files/food-booking/bills-pdf/");
            // if (file_exists($pdfname)) {
            //     ob_start();
            //     header("Content-Type:application/pdf");
            //     readfile($pdfname);
            //     $imageContent = ob_get_clean();
            //     header_remove('Content-Length');
            //     echo $imageContent;
            // } else {
            //     chdir($_SERVER['DOCUMENT_ROOT'] . "/../other-modules/");
            //     $data = $food->getStaffFoodDetails($_SESSION['yourToken']);
            //     $pdfname = $_SESSION['yourToken']."-".$row['event_date'];
            //     $totalPeople = $data['quantity'] ;
            //     $totalCost = $data['cost'];
            //     $food_combo = $data['food_combo'];
            //     $event_date = $data['event_date'];
            //     $event_name = $data['event_name'];
            //     $a = exec("python3 pdf-maker-food-booking.py $pdfname $totalPeople $totalCost $food_combo $event_date $event_name ");
            //     echo "Reload again";
            // }
            // header("Content-Type:application/pdf");
            ?>
            <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Food Order Bill Invoice</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <?php
        include_once $_SERVER["DOCUMENT_ROOT"] . "/../" . "template/admin-template/common-template/poppins.php";

    ?>
<style>
    /*body {*/
    /*    margin: 0;*/
    /*    padding: 0;*/
    /*    background-color: #f2f2f2;*/
    /*}*/

    .container-1 {
        max-width: 1300px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 1px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1 {
        color: #333;
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    .total {
        text-align: right;
        font-weight: bold;
    }

    .footer {
        margin-top: 20px;
        text-align: center;
        color: #777;
    }
</style>
<style>
                    .container-1 {
                        max-width: 95%;
                        margin: 5px auto;
                        border: 1px solid #ccc;
                        padding: 20px;
                        background-color: white;
                    }
                    .box {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        border: 1px solid #ccc;
                        padding: 20px;
                        border-radius: 1px;
                        text-align: center;
                        background-color: #fafafa;
                    }
                    .box .icon {
                        font-size: 1.5em;
                        margin-bottom: 10px;
                    }
                    .box .title {
                        font-weight: bold;
                    }
                    .box .subtitle {
                        color: gray;
                    }
                    @media (max-width: 768px) {
                        .mt-6 {
                            margin-top: 90px !important;
                        }
                    }
                </style>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <?php
        include_once $_SERVER["DOCUMENT_ROOT"] . "/../" . "template/staff-template/common-template/navbar.php";

    ?>
      
                <div class="container-fluid col-lg-12 col-md-12 mt-3 mb-2 w-100">
                    <div class="box">
                        <div class="icon mb-2"><img style="width: 40px;height:40px;" src="/images/layout-image/download.png" alt=""></div>
                        <div class="title mb-2">
                            <button id="download-button" class="btn btn-dark rounded-1" >Download</button>
                        </div>
                        <div class="subtitle">click to download the food bill info</div>
                    </div>
                </div>
  
    <div id="html-content" class="container-1 mt-4 box mb-5">

        <div class="header">
                <img class='img-fluid float-left' style='img-float:left;' src='https://srec.ac.in/themes/frontend/images/logo.png' width='400' height='400'>

            <h3 class='display-6 fs-3'>Food Order Bill Invoice</h3>
            <p>Issued on: <?php echo date("d-m-Y") ?></p>
        </div>
        <table>
            <tr>
                <th>Description</th>
                <th>Number of people</th>
                <th>Price(single entity)</th>
                <th>Total Amount</th>
            </tr>
            
            <tr>
                <td>Food Required</td>
                <td><?php echo $row['quantity'] ?></td>
                <td><?php echo (int)($row['cost'])/(int)($row['quantity']) ?> Rs</td>
                <td><?php echo $row['quantity'] * ((int)($row['cost'])/(int)($row['quantity'])) ?> Rs</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Final Amount</td>
                <?php // echo $row['cost']."  ".$row['quantity'] ?>
                <td><?php echo $row['quantity'] * ((int)($row['cost'])/(int)($row['quantity'])) ?>  Rs</td>
            </tr>
        </table>
        <div class="footer">
            <p>Thank you for Ordering Food !</p>
        </div>
    </div>
     <script>
        const button = document.getElementById('download-button');

        function generatePDF() {
            // Choose the element that your content will be rendered to.
            const element = document.getElementById('html-content');
            // Choose the element and save the PDF for your user.
             const opt = {
            margin:       0.5,           // Define the margins (in inches)
            html2canvas:  { scale: 2}, // Increase the scale to zoom in
        };
        html2pdf().from(element).set(opt).save("<?php echo $_SESSION['yourToken'] ?>.pdf");
        }

        button.addEventListener('click', generatePDF);
    </script>
</body>
</html>
            <?php
        } else {
            echo "something went wrong";
        }
    } else {
        echo "something went wrong";
    }
} else {
    echo "something went wrong";
}
