<?php
chdir("/home/u219671451/domains/srechostel.in/jobs/");
include_once "connection.php";
?>

<?php
$conn = new Connection();
$sqlConn = $conn->returnConn();
$sqlQuery = "TRUNCATE token_system_backup;";
if ($sqlConn->query($sqlQuery)) {
    $sqlQuery = "INSERT INTO token_system_backup  SELECT * FROM token_system;";
    if ($sqlConn->query($sqlQuery)) {
        //this part run when the query is runned successfully
    }
}



?>