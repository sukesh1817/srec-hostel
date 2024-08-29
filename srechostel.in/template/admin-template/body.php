<body class="noto-sans">

<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . "/../template/admin-template/common-template/navbar.php";
?>
    <div class="bg-light-subtle">
        <main class="bg-img">
            <div class="container-fluid py-4">

                <div class="p-5 mb-4 bg-light rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">Student Details</h1>
                        <p class="col-md-8 fs-4">Here You Can See About The Student Details By Clicking
                            The Below Button.</p>
                        <a href="/admin-panel/stud-details" class="btn btn-dark rounded-1 btn-lg">See Details</a>
                    </div>
                </div>

                <div class="row align-items-md-stretch">
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-dark rounded-3">
                            <h2 style="color:#fff">Token Records</h2>
                            <p style="color:#fff">Here You Can See About The Token Records By Click The
                                Below
                                Button.</p>
                            <a href="/admin-panel/token-records" class="btn btn-outline-light rounded-1 btn-lg" type="button">
                                See Details
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                            <h2>Accommodation</h2>
                            <p>Here You Can See About Latest Accommodation By Click The Below Button.</p>
                            <a href="/admin-panel/accommodation" class="btn btn-outline-dark rounded-1 btn-lg" type="button">
                                See Details
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row align-items-md-stretch">
                    
                    
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                            <h2>Complaint</h2>
                            <p>Here You Can See About Latest complaints By students.</p>
                            <a href="/admin-panel/complaint/" class="btn btn-dark rounded-1 btn-lg" type="button">
                                See Details
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5 bg-dark rounded-3">
                            <h2 style="color:#fff">Gate Pass</h2>
                            <p style="color:#fff">Here You Can See About The Gatepass from the student.</p>
                            <a href="/admin-panel/gate-pass/" class="btn btn-light rounded-1 text-dark btn-lg" type="button">
                                See Details
                            </a>
                        </div>
                    </div>
                    
                    
                </div>

                <div class="row align-items-md-stretch">
                    
                    
                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5  bg-dark border rounded-3">
                            <h2 class="text-light">Committee</h2>
                            <p class="text-light">Here You Can See About The Committee from the student.</p>
                            <a href="/admin-panel/committee/" class="btn btn-outline-light rounded-1 btn-lg" type="button">
                                See Details
                            </a>
                        </div>
                    </div>
                    

                    <div class="col-md-6 mb-4">
                        <div class="h-100 p-5  bg-body-tertiary border rounded-3">
                            <h2 class="text-dark">Food Order</h2>
                            <p class="text-dark">Here You Can See About Food Orders from the staff.</p>
                            <a href="/admin-panel/food-orders/" class="btn btn-outline-dark rounded-1 btn-lg" type="button">
                                See Details
                            </a>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row align-items-md-stretch">
                    <div class="col-md-6 col-lg-12 mb-4">
                        <div class="h-100 p-5  bg-dark border rounded-3">
                            <h2 class="text-light">Add Data</h2>
                            <p class="text-light">Add the student data using this form.</p>
                            <a href="/admin-panel/add-student-records/" class="btn btn-light rounded-1 btn-lg">
                                See Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>