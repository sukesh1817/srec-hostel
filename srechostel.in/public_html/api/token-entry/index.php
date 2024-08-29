<?php
//check first this is admin if it is admin then allow it else do not allow
$isAdmin=1;
if($isAdmin){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['roll-no']) and isset($_POST['which'])){
            include_once $_SERVER['DOCUMENT_ROOT'] . "/../class-files/token.class.php";
            $token = new Token();
            $checked = $token->checkTheToken($_POST['roll-no'],$_POST['which']);
            header("Content-Type: application/json");
            if($checked){
                    echo '{"Message":"Token marked success"}';

            } else {
                    echo '{"Message":"Token marked failed"}';

            }
        } else {
            header("Content-Type: application/json");
            echo '{"Message":"Wrong parameter"}';
        }
    } else {
        header("Content-Type: application/json");
        echo '{"Request":"Method not allowed"}';
    }
    
} else {
    header("Content-Type: application/json");
    echo '{"Request":"un authorized"}';
}
