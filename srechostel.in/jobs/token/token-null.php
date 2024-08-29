<?php
chdir("/home/u219671451/domains/srechostel.in/jobs/");
include_once "connection.php";
?>

<?php
$conn = new Connection();
$sqlConn = $conn->returnConn();
$sqlQuery = "UPDATE `token_system` SET token_booked=0;";
if($sqlConn->query($sqlQuery)){
    //this part run when the query is runned successfully
}


?>