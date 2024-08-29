<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";

include_once($_SERVER["DOCUMENT_ROOT"] . "/../class-files/pass.class.php");

if($_SERVER["REQUEST_METHOD"]=="GET" ) {
    if(isset($_GET["rollNo"]) AND isset($_GET["type"])){
        $rollNo = $_GET["rollNo"];
        $type = $_GET["type"];
        $dept = urlencode($_GET["which-dept"]);
        
        $pass = new Pass_class();
        $result = $pass->acceptThePass($rollNo,$type);
        if($result){
            $ip=$_SERVER["SERVER_ADDR"];
            header("Location: http://$ip/admin-panel/gate-pass/?status=pending&pass-type=$type&which-dept=$dept");
        } else {
            $ip=$_SERVER["SERVER_ADDR"];
            header("http://$ip/");
        }
    }
}