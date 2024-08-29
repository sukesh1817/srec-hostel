<?php
/*
this part of the code clear the previous accommodation request ,
*/

    include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-staff.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clear accommodation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
?>
</head>
<body>


<?php
/*
this file takes input staff_id and accomodation_status ,
and it change the accomdation_status from pending to (acceted or declined) ,
based on the request.
*/
if (isset($_SESSION['yourToken'])) {
        include_once $_SERVER["DOCUMENT_ROOT"] . '/..' . "/class-files/accommodation.class.php";
        $accom = new accommodation();
        $id = $_SESSION['yourToken'];
        $result = $accom->clearAccom($id);
        if($result){
            ?>
<div class="bg-body-tertiary p-5 rounded mt-3">
    <h1>Accomodation cleared</h1>
    <p class="lead">Now you can able to book new accommodation.</p>
    <a class="btn btn-lg btn-dark rounded-1" href="/staff-panel/" role="button">back</a>
  </div>
            <?php
        } else {
            ?>
<div class="bg-body-tertiary p-5 rounded mt-3">
    <h1>Something went wrong</h1>
    <p class="lead">some problem is arised in the server side please try again later</p>
    <a class="btn btn-lg btn-dark rounded-1" href="/" role="button">back</a>
  </div>
            <?php
        }
    
} else {
   echo "<h3>error : please login again before entry</h3>";
   echo "<script>
   const redir = setTimeout(href, 5000);
   function href(){
   window.location.href = '/';
   }
</script>";
}

?>

</body>
</html>


