<?php


include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-staff.php";
?>

<?php
if (isset($_SESSION["yourToken"])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $staffId = $_SESSION['yourToken'];
    $sqlQuery = "SELECT * FROM accom_accepted_request WHERE staff_id='$staffId' ;";
    $result = $sqlConn->query($sqlQuery);
    $row = $result->fetch_assoc();
    if ($result) {
        if (isset($row['pdf_name'])) {
            // $pdfname = $row['pdf_name'] . ".pdf";
            // chdir($_SERVER['DOCUMENT_ROOT'] . "/../files/accomodation/bills-pdf/");
            // if (file_exists($pdfname)) {
            //     ob_start();
            //     header("Content-Type:application/pdf");
            //     readfile($pdfname);
            //     $imageContent = ob_get_clean();
            //     header_remove('Content-Length');
            //     echo $imageContent;
            // } else {
            //     chdir($_SERVER['DOCUMENT_ROOT'] . "/../other-modules/");
            //     include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/accommodation.class.php";
            //     // echo $_SESSION['yourToken'];
            //     $accom = new accommodation();
            //     $data = $accom->getMyData($_SESSION['yourToken']);
            //     $pdfname = $row['pdf_name'];
            //     $totalPeople = $data['no_of_male_student'] + $data['no_of_female_student'] + $data['no_of_male_staff'] + $data['no_of_female_staff'];
            //     $totalRoom = $data['no_of_male_student_room'] + $data['no_of_female_student_room'] + $data['no_of_female_staff_room'] + $data['no_of_male_staff_room'];
            //     $checkin = $data['accom_check_in_date'];
            //     $checkout = $data['accom_check_out_date'];
            //     $a = exec("python3 pdf-maker-accommodation.py $pdfname $totalPeople $totalRoom $checkin $checkout ");
            //     echo "Reload again";

            // }
            
            ?>
            <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bill Invoice</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../" . "template/admin-template/common-template/poppins.php";

?>
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }

    .container-1 {
        max-width: 900px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
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
                    @media screen and (max-width: 425px) {
  .hide-on-small {
    display: none;
  }
}

                </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <?php
        include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../template/staff-template/common-template/navbar.php";
    ?>
    
     <style>
        @media screen and (max-width: 425px) {
            .hide-on-small {
                display: none;
            }
        }
        .box {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }
        .header, .footer {
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>

    <div class="container-fluid col-lg-12 col-md-12 mt-3 mb-2 w-100">
        <div class="box">
            <div class="icon mb-2">
                <img style="width: 40px; height: 40px;" src="/images/layout-image/download.png" alt="Download Icon">
            </div>
            <div class="title mb-2">
                <button id="download-button" class="btn btn-dark rounded-1">Download</button>
            </div>
            <div class="subtitle">Click to download the food bill info</div>
        </div>
    </div>
                
    <div id="html-content" class="container mt-4 box mb-5 hide-on-small">
        <div class="header">
            <h1 class="display-6 fs-3">Accommodation Bill Invoice</h1>
            <p>Issued on: <?php echo date("d-m-Y")?></p>
        </div>
        <table>
            <tr>
                <th>Description</th>
                <th>Total Quantity</th>
                <th>Price (single entity)</th>
                <th>Total Amount</th>
            </tr>
            <tr>
                <td>Room Alloted</td>
                <td><?php echo $row['no_of_male_student_room']+$row['no_of_female_student_room']+$row['no_of_male_staff_room']+$row['no_of_female_staff_room'] ?></td>
                <td>250 Rs</td>
                <td><?php $roomCost = ($row['no_of_male_student_room']+$row['no_of_female_student_room']+$row['no_of_male_staff_room']+$row['no_of_female_staff_room'])*250; echo $roomCost; ?> Rs</td>
            </tr>
            <tr>
                <td>Food Required</td>
                <td><?php echo $row['no_of_male_student']+$row['no_of_female_student']+$row['no_of_male_staff']+$row['no_of_female_staff'] ?></td>
                <td>150 Rs</td>
                <td><?php $foodCost = ($row['no_of_male_student']+$row['no_of_female_student']+$row['no_of_male_staff']+$row['no_of_female_staff'])*150; echo $foodCost;?> Rs</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Final Amount</td>
                <td><?php echo $roomCost+$foodCost; ?> Rs</td>
            </tr>
        </table>
        <div class="footer">
            <p>Thank you for Ordering Accommodation!</p>
        </div>
    </div>
    
    <script>
        const button = document.getElementById('download-button');

        function generatePDF() {
            if(document.getElementById("html-content").classList.contains("hide-on-small")){
                document.getElementById("html-content").classList.remove("hide-on-small")
            }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

            <?php
        } else {
            echo "Order is not accepted";
        }
    } else {
        echo "please login again";
        echo "<a href='/logout'>login again</a>";
    }
} else {
    echo "something went wrong";
}



