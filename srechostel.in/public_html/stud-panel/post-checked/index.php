<?php
//files that needed 
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-stud.php";
require_once $_SERVER['DOCUMENT_ROOT']."/..".'/composer/vendor/autoload.php';

//create a connection
$client = new MongoDB\Client('mongodb://127.0.0.1:27017/');
$database = $client->selectDatabase('hostelmanagment');


//create collection if collection is not exists
if(isset($_POST['post-id'])) {
    try {
        $createCollection = $database->createCollection("c_".$_SESSION['yourToken']);
    }
    catch(Exception $e){
        $id=$_POST['post-id'];
        $filter  = ['_id'=>$id];
        $collection=$database->selectCollection("c_".$_SESSION['yourToken']);
        $updateResult = $collection->updateOne(
            [ 'notiId' => $id ],
            [ '$set' => [ 'checked' => 1 ]]
        );
        header("Content-Type: application/json");
        echo '{"message":"success"}';
    }    

}

else {
    header("Content-Type: application/json");
    echo '{"error":"un_recognized"}';
}






