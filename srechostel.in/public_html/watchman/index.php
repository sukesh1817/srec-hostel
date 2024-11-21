<?php
// Check the login person is authenticated.
// include_once $_SERVER['DOCUMENT_ROOT'] . "/is-watch-man.php";

// Include the main domain.
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../config/' . "domain.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo $domain; ?>/css-files/scan.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<title>QR Entry</title>
	<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . "/__common/poppins.php";
	?>
</head>

<body class="bg-secondary-subtle">


	<div id="scan-container" class="container">
		<div id="scanner">
			<h1 class="mt-3">Scan The QR To Entry</h1>
			<div class="section">
				<div id="my-qr-reader">
				</div>
				<button class="html5-qrcode-element" onclick="window.location.href='<?php echo $domain; ?>/api/auth/logout'">Logout</button>
			</div>
		</div>
	</div>
	
	<div id="entry-container" class="container">
		<input id="qr-url" type="hidden" value="">
		<div class="px-4 py-5 my-5 text-center">
			<img class="d-block mx-auto mb-4" src="images/layout-image/security-guard.png" alt="" width="72"
				height="65">
			<h1 class="display-5 fw-bold text-body-emphasis">Entry the student</h1>
			<div class="col-lg-6 mx-auto">
				<p class="lead mb-4">Click the below button to entry the student.</p>
				<div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
					<button id="entry-btn" type="button" class="btn btn-dark btn-lg px-4 gap-3 rounded-1">Click to
						entry</button>
				</div>
			</div>
		</div>
	</div>

	<script src="https://unpkg.com/html5-qrcode"></script>
	<script src="<?php echo $domain; ?>/js-files/api/watch-man/scan.js"></script>
</body>

</html>