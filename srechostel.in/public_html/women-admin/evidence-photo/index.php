<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "is-admin.php";


function seePdf($imageName) {
    $path="";
    // echo $imageName;
    if($_GET['w']=='c') {
        $path = "common-complaints";
    } else if($_GET['w']=='i') {
        $path = "individual-complaints";
    }
    // echo $path;
    $extension =  strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    chdir($_SERVER['DOCUMENT_ROOT']."/../files/complaints/$path");
    if(file_exists($imageName)){
        ob_start();
        header("Content-Type:image/$extension");
        readfile($imageName);
        $imageContent = ob_get_clean();
        header_remove('Content-Length');
        echo $imageContent;
    } else {
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>File Not Found</title>
	<link href="https://fonts.googleapis.com/css?family=Kanit:200" rel="stylesheet">
	<!-- <link type="text/css" rel="stylesheet" href="{{url('css/font-awesome.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{url('css/style.css')}}" /> -->
    <style>
        
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
	box-sizing: border-box;
}


body {
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	font-family: 'Montserrat', sans-serif;
	margin: -20px 0 50px;
	height: 500px;
	width: 100%;
}

h1 {
	font-weight: bold;
	margin: 0;
}

h2 {
	text-align: center;
}

p {
	font-size: 14px;
	font-weight: 100;
	line-height: 20px;
	letter-spacing: 0.5px;
	margin: 20px 0 30px;
}

span {
	font-size: 12px;
}

a {
	color: #333;
	font-size: 14px;
	text-decoration: none;
	margin: 15px 0;
}

.not-found{
	background-image: url(./error.jpg);
	object-fit: cover;
	height: 200px;
	width: 100px;
}



    </style>


</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1 style="text-align: center"><u>OOPS</u></h1>
			</div>
			<h2 style="text-align: center">File Not Found</h2>
			<p style="text-align: center">The file you are looking for is corrupted or deleted on server.</p>
		</div>
	</div>
</body>
</html>

        <?php
    }
  

}
if (isset($_GET['roll-no']) and isset($_GET['w'])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/" . "../class-files/connection.class.php";
    $conn = new Connection();
    $sqlConn = $conn->returnConn();
    $rollNo = $_GET['roll-no'];

    if ($_GET['w'] == 'c') {
        $sqlQuery = "SELECT image_path FROM common_complaint WHERE roll_no=$rollNo ;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row['image_path'])) {
                $imageName = $row['image_path'];
                seePdf($imageName);

            } else {
                echo "something looking bad";
            }
        }


    } else if ($_GET['w'] == 'i') {

        $sqlQuery = "SELECT image_path FROM individual_complaint WHERE roll_no=$rollNo ;";
        $result = $sqlConn->query($sqlQuery);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row['image_path'])) {
                $imageName = $row['image_path'];
                seePdf($imageName);
            } else {
                echo "something looking bad";
            }
        }

    } else {
        echo "bad request url";
    }

} else {
    echo "something went wrong";
}

