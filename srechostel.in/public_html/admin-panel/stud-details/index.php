<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/poppins.php";
?>
</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
    ?>
    <div class="container mt-5">
        <p class='text-center fs-2'>Student details</p>
        <hr>
        <div class="row mt-3">
            <div class="col-lg-4 col-md-6">
                <div class="card" style="width: 23rem;">
                    <form method="post" action="/admin-panel/stud-details/search/">
                        <div class="card-body">
                            <h5 class="card-title">Men hostel 1</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">Student details</h6>
                            <input type="hidden" name="hostel" value="Men-hostel-1">
                            <p class="card-text">Here you can see the records of the men's hostel 1.</p>
                            <button type="submit" class="btn btn-dark rounded-1 card-link">click to Search</button>

                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card" style="width: 23rem;">
                    <form method="post" action="/admin-panel/stud-details/search/">
                        <div class="card-body">
                            <h5 class="card-title">Men hostel 2</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">Student details</h6>
                            <input type="hidden" name="hostel" value="Men-hostel-2">
                            <p class="card-text">Here you can see the records of the men's hostel 2.</p>
                            <button type="submit" class="btn btn-dark rounded-1 card-link">click to Search</button>

                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card" style="width: 23rem;">
                    <form method="post" action="/admin-panel/stud-details/search/">
                        <div class="card-body">
                            <h5 class="card-title">International hostel</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">Student details</h6>
                            <input type="hidden" name="hostel" value="International-hostel">
                            <p class="card-text">Here you can see the records of the International hostel .</p>
                            <button type="submit" class="btn btn-dark rounded-1 card-link">click to Search</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>