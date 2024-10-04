<?php
/*
this code check wheather the login person is staff or not,
if staff proceed next,
else do not allow the person
*/
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";
?>

<?php
function seePdf($pdfname) {
    chdir($_SERVER['DOCUMENT_ROOT']."/../files/accomodation/bills-pdf/");
    echo getcwd();
    header('Content-Type:application/pdf');
    include_once($pdfname.'.pdf');
}
if(isset($_GET['staff-id'])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $staffId=$_GET['staff-id'];
    $sqlQuery="SELECT pdf_name FROM accom_pending_request WHERE staff_id=$staffId ;";
    $result=$sqlConn->query($sqlQuery);
    if($result) {
        $row=$result->fetch_assoc();
        if(isset($row['pdf_name'])) {
            $pdfname = $row['pdf_name'];
           seePdf($pdfname);
        } else {
            $sqlQuery="SELECT pdf_name FROM accom_accepted_request WHERE staff_id=$staffId ;";
            $result=$sqlConn->query($sqlQuery);
            if($result) {
                $row=$result->fetch_assoc();
                if(isset($row['pdf_name'])) {
                    $pdfname = $row['pdf_name'];
                    seePdf($pdfname);
                } else {
                    echo "something went wrong";
                }
            }
        }
    } else {
        echo "something went wrong";
    }
} else {
    echo "something went wrong";
}



?>

