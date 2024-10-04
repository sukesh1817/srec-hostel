<?php
use League\Csv\Reader;

/*
this code checks wheather the person is admin or not,
if admin allow them ,
else do not allow them
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/../composer/" . 'vendor/autoload.php';

function read_column_names($filePath)
{
    // Load the CSV document from a file path
    $csv = Reader::createFromPath($filePath, 'r');

    // Set the header offset to get the column names
    $csv->setHeaderOffset(0);

    // Get the column names (first row)
    $columnNames = $csv->getHeader();

    return $columnNames;
}
function formDetails()
{
    $htmlContent = <<<EOL
 <div class="row">
                <div class="col-md-12 col-lg-6 d-flex align-item-center justify-content-center ">
                    <div class="container m-5">
                        <h2>Add Your Data</h2>
                        <hr>
                        <form class="container-fluid" id="thisIsForm" action="../add-data/" method="POST">
                            <div>
                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="name" type="text" id="name"
                                        placeholder="Full name" required>

                                </div>

                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="department" type="text" id="department"
                                        placeholder="department" required>
                                    <input class="container-fluid ms-1" name="roomNo" type="text" id="roomNo"
                                        placeholder="Room no" required>

                                </div>

                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="yearOfStudy" type="number" id="yearOfStudy"
                                        placeholder="Student year" required>
                                    <input class="container-fluid ms-1" name="hostel" type="text" id="hostel"
                                        placeholder="Which hostel" required>
                                </div>

                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="rollNo" type="number" id="rollNo"
                                        placeholder="Roll no" required>


                                    <input class="container-fluid ms-1" onfocus="(this.type='date')" 
onblur="(this.type='text')"
                                        type="text" name="dateOfBirth" type="date" id="dateOfBirth" placeholder="Date of 
birth"
                                        required>
                                </div>

                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="tutorName" type="text" id="tutorName"
                                        placeholder="Tutor name" required>

                                    <input class="container-fluid ms-1" name="acName" type="text" id="AcName"
                                        placeholder="Ac Name" required>

                                </div>

                                <div class="d-flex">

                                    <input class="container-fluid ms-1" name="email" type="email" id="email" 
placeholder="Email"
                                        required>

                                    <input class="container-fluid ms-1" name="bloodGroup" type="text" id="bloodGroup"
                                        placeholder="Blood group" required>
                                </div>

                                <div class="d-flex">

                                    <input class="container-fluid ms-1" name="fatherName" type="text" id="fatherName"
                                        placeholder="Father name" required>

                                    <input class="container-fluid ms-1" name="motherName" type="text" id="motherName"
                                        placeholder="Mother name" required>
                                </div>

                                <div class="d-flex">

                                    <input class="container-fluid ms-1" name="fatherNo" type="number" id="fatherNo"
                                        placeholder="Father number" required>

                                    <input class="container-fluid ms-1" name="motherNo" type="number" id="motherNo"
                                        placeholder="Mother number" required>
                                </div>

                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="contactNo" type="text" id="contactNo"
                                        placeholder="Personal number" required>
                                </div>

                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="address" type="text" id="address"
                                        placeholder="Address" required>
                                </div>

                                <div class="d-flex">
                                    <input class="container-fluid ms-1" name="pincode" type="number" id="pincode"
                                        placeholder="Pincode" required>
                                </div>

                                <div class="d-flex">

                                    <input class="container-fluid ms-1" name="gurdianName" type="text" id="gurdianName"
                                        placeholder="Gurdian name" required>

                                    <input class="container-fluid ms-1" name="gurdianNo" type="text" id="gurdianNo"
                                        placeholder="Gurdian number" required>
                                </div>


                            </div>


                            <button class="btn btn-dark rounded-1 mb-2" style="margin-top: 4px;" 
type="submit">Finish</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-1 col-md-none d-flex align-item-center justify-content-center mt-5 vl">
                </div>

                <div class="col-md-12 col-lg-5 d-flex align-item-center justify-content-center mt-5">

                    <form class="box" method="post" action="/admin-panel/add-student-records/" enctype="multipart/form-data">
                        <div class="drop-zone">
                            <span class="drop-zone__prompt">Drop file here or click to upload<br>(Note : please upload xlsx 
or
                                csv)</span>
                            <input type="file" name="excel-file" class="drop-zone__input">
                        </div>
                        <button class="btn btn-dark rounded-1 mb-2 mt-2" style="margin-top: 4px;" type="submit">Upload
                            the file</button>

                    </form>
                </div>
            </div>
    

EOL;
    echo $htmlContent;
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add student data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <style>
        /* Container Styles */
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 5px;
            width: 400px;
            align-content: center;
            margin: auto;
            align-items: center;
        }

        /* Heading Styles */
        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="email"],

        select {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }



        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .drop-zone {
            max-width: 500px;
            height: 400px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: "Quicksand", sans-serif;
            font-weight: 500;
            font-size: 20px;
            cursor: pointer;
            color: #cccccc;
            border: 4px dashed black;
            border-radius: 10px;
        }

        .drop-zone--over {
            border-style: solid;
        }

        .drop-zone__input {
            display: none;
        }

        .drop-zone__thumb {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
            background-color: #cccccc;
            background-size: cover;
            position: relative;
        }

        .drop-zone__thumb::after {
            content: attr(data-label);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 5px 0;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.75);
            font-size: 14px;
            text-align: center;
        }

        .vl {
            border-left: 3px groove black;
            height: 800px;
        }
    </style>
</head>

<body>


    <?php
    if (isset($_FILES['excel-file'])) {
        $extension = explode(".", strtolower($_FILES['excel-file']['name']))[1];
        $isValidFile = 1;
        if (!($extension == "csv" or $extension == "xlsx")) {
            $isValidFile = 0;
        }
        if ($isValidFile) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/../class-files/" . "excel.class.php";
            chdir($_SERVER["DOCUMENT_ROOT"] . '/..' . "/files/excel-files/main-excel-files/");
            $excel = new Excel_class();
            // print_r($excel);
            // exit;
            $fileName = $excel->uploadTheFile($_FILES['excel-file']);
            if ($fileName) {
                $columnNames = read_column_names($fileName);
                $firstColumn = "None";
                foreach ($columnNames as $columnName) {
                    $firstColumn = $columnName;
                    break;
                }
            }
            
            if ($firstColumn == "roll_no" or $firstColumn == "staff_id") {
                if($firstColumn=="roll_no"){
                    $result = $excel->splitTheSheet($fileName,"student");
                } else {
                    $result = $excel->splitTheSheet($fileName,"staff");
                } 
            } else {
                ?>
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img src="/images/layout-image/warning.png" class="rounded me-2" width="20" height="20" 
alt="...">
                            <strong class="me-auto">Column error</strong>
                            <small>Just ago</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Invalid column field the first field of the column must be 'roll_no' or 'staff_id'
                        </div>
                    </div>
                </div>
                <?php
            }




        } else {
            unset($_FILES['excel-file']);
            ?>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <img src="/images/layout-image/warning.png" class="rounded me-2" width="20" height="20" alt="...">
                        <strong class="me-auto">Upload error</strong>
                        <small>Just ago</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        please upload the file format with csv or xlsx
                    </div>
                </div>
            </div>
            <?php
            formDetails();

        }
    } else if
    (
        isset($_POST["name"]) and
        isset($_POST["department"]) and
        isset($_POST["roomNo"]) and
        isset($_POST["rollNo"]) and
        isset($_POST["dateOfBirth"]) and
        isset($_POST["tutorName"]) and
        isset($_POST["acName"]) and
        isset($_POST["email"]) and
        isset($_POST["bloodGroup"]) and
        isset($_POST["fatherName"]) and
        isset($_POST["motherName"]) and
        isset($_POST["fatherNo"]) and
        isset($_POST["motherNo"]) and
        isset($_POST["contactNo"]) and
        isset($_POST["address"]) and
        isset($_POST["pincode"]) and
        isset($_POST["gurdianName"]) and
        isset($_POST["gurdianNo"]) and
        isset($_POST["yearOfStudy"]) and

        isset($_POST["hostel"])

    ) {

        include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";

        $name = $_POST["name"];
        $dept = $_POST["department"];
        $roomNo = $_POST["roomNo"];
        $rollNo = $_POST["rollNo"];
        $dob = $_POST["dateOfBirth"];
        $tutorName = $_POST["tutorName"];
        $acName = $_POST["acName"];
        $email = $_POST["email"];
        $bloodGroup = $_POST["bloodGroup"];
        $fatherName = $_POST["fatherName"];
        $motherName = $_POST["motherName"];
        $fatherNo = $_POST["fatherNo"];
        $motherNo = $_POST["motherNo"];
        $contactNo = $_POST["contactNo"];
        $address = $_POST["address"];
        $pincode = $_POST["pincode"];
        $gurdianName = $_POST["gurdianName"];
        $gurdianNo = $_POST["gurdianNo"];
        $studyYear = $_POST["yearOfStudy"];
        $whichHostel = $_POST['hostel'];

        $conn = new Connection();
        $sqlConn = $conn->returnConn();
        try {

            $sqlQuery_1 = "INSERT INTO `stud_details` 
VALUES('$whichHostel','$studyYear','$name','$rollNo','$dept','$tutorName','$acName');";
            $sqlQuery_2 = "INSERT INTO `stud_personal_details` VALUES('$name','$rollNo','$email','$dob' 
,'$bloodGroup','$dept','$roomNo','$contactNo'
           ,'$address','$pincode');";
            $sqlQuery_3 = "INSERT INTO `stud_gurdian_details` 
VALUES('$name','$rollNo','$fatherName','$motherName','$gurdianName','$fatherNo',
            '$motherNo','$gurdianNo');";

            if ($sqlConn->query($sqlQuery_1) and $sqlConn->query($sqlQuery_2) and $sqlConn->query($sqlQuery_3)) {
                ?>
                    <div class="p-5 m-4 bg-body-tertiary rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 mb-2 fw-bold">Record Added Successfully</h1>
                            <p class="col-md-8 fs-4">Want To Add New Record</p>
                            <a href="../add-data" class="btn btn-dark btn-lg text-white rounded-1" type=".btn-orange">Add 
Record</a>
                        </div>
                    </div>
                <?php
            }
        } catch (Exception $exc) {
            ?>
                <div class="p-5 m-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 mb-2 fw-bold">Record Already Found</h1>
                        <p class="col-md-8 fs-4">Please Add Another Record</p>
                        <a href="../add-data" class="btn btn-dark btn-lg text-white rounded-1" type=".btn-orange">Add 
Record</a>
                    </div>
                </div>

            <?php
        }

    } else {
        formDetails();
    }

    ?>


    <script>
        document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
            const dropZoneElement = inputElement.closest(".drop-zone");

            dropZoneElement.addEventListener("click", (e) => {
                inputElement.click();
            });

            inputElement.addEventListener("change", (e) => {
                if (inputElement.files.length) {
                    updateThumbnail(dropZoneElement, inputElement.files[0]);
                }
            });

            dropZoneElement.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropZoneElement.classList.add("drop-zone--over");
            });

            ["dragleave", "dragend"].forEach((type) => {
                dropZoneElement.addEventListener(type, (e) => {
                    dropZoneElement.classList.remove("drop-zone--over");
                });
            });

            dropZoneElement.addEventListener("drop", (e) => {
                e.preventDefault();

                if (e.dataTransfer.files.length) {
                    inputElement.files = e.dataTransfer.files;
                    updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }

                dropZoneElement.classList.remove("drop-zone--over");
            });
        });

        /**
         * Updates the thumbnail on a drop zone element.
         *
         * @param {HTMLElement} dropZoneElement
         * @param {File} file
         */
        function updateThumbnail(dropZoneElement, file) {
            let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

            // First time - remove the prompt
            if (dropZoneElement.querySelector(".drop-zone__prompt")) {
                dropZoneElement.querySelector(".drop-zone__prompt").remove();
            }

            // First time - there is no thumbnail element, so lets create it
            if (!thumbnailElement) {
                thumbnailElement = document.createElement("div");
                thumbnailElement.classList.add("drop-zone__thumb");
                dropZoneElement.appendChild(thumbnailElement);
            }

            thumbnailElement.dataset.label = file.name;

            // Show thumbnail for image files
            if (file.type.startsWith("image/")) {
                const reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = () => {
                    thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
                };
            } else {
                thumbnailElement.style.backgroundImage = null;
            }
        }

    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script>
        const toastLiveExample = document.getElementById('liveToast')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastBootstrap.show()
    </script>
</body>

</html>
