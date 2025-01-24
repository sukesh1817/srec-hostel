$(document).ready(function () {
    
    $("#entry-container").hide();

    const config = {
        fps: 20,
        qrbox: function (viewfinderWidth, viewfinderHeight) {
            const minDimension = Math.min(viewfinderWidth, viewfinderHeight);
            return {
                width: minDimension * 0.75,
                height: minDimension * 0.75
            };
        }
    };

    const htmlscanner = new Html5QrcodeScanner(
        "my-qr-reader",
        config,
    /* verbose= */ false
    );


    $("#entry-btn").click(function () {
        let url = $("#qr-url").val()
        url = url + "&auth_session_id=" + auth_session_id;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                if (response.status.action === "success" && (response.status.Message === "Successfully Checkin" || response.status.Message === "Successfully Checkout")) {
                    var name = response.details.name;
                    var rollNo = response.details.rollNo;
                    var roomNo = response.details.roomNo;
                    var timeEnter = response.details.timeEnter;
                    var timeLeave = response.details.timeLeave;
                    var dateEnter = response.details.dateEnter;
                    var dateLeave = response.details.dateLeave;
                    var passType = response.details.passType;
                    var hostel = response.details.hostel;
                    var dept = response.details.dept;
                    var address = response.details.address;
                    var acceptedBy = response.details.acceptedBy;
                    var url = response.details.profile_url;
                    const myElement = document.getElementById("entry-container");
                    myElement.innerHTML = " ";
                    myElement.innerHTML = `
                <style>
                    .container-1 {
                        max-width: 95%;
                        margin: 5px auto;
                        border: 1px solid #ccc;
                        padding: 20px;
                        background-color: white;
                    }
                    .avatar {
                        vertical-align: middle;
                        width: 150px;
                        height: 150px;
                        border-radius: 50%;
                        object-fit: cover;
                    }
                    .box {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        border: 1px solid #ccc;
                        padding: 20px;
                        border-radius: 1px;
                        text-align: center;
                        background-color: #fafafa;
                    }
                    .box .icon {
                        font-size: 1.5em;
                        margin-bottom: 10px;
                    }
                    .box .title {
                        font-weight: bold;
                    }
                    .box .subtitle {
                        color: gray;
                    }
                    @media (max-width: 768px) {
                        .mt-6 {
                            margin-top: 90px !important;
                        }
                    }
                </style>
                <div class="container-fluid col-lg-12 col-md-12 mt-3 mb-2 w-100">
                    <div class="box">
                        <div class="icon mb-2"><img style="width: 40px;height:40px;" src="/images/layout-image/download.png" alt=""></div>
                        <div class="title mb-2">
                            <button class="btn btn-dark rounded-1" onclick="window.location.reload();">Click to scan next QR</button>
                        </div>
                        <div class="subtitle">Scan the next QR</div>
                    </div>
                </div>
                <div id="html-content">
                    <div class="container-1">
                        <h3 class="text-center title fw-bold">${passType} ${response.status.Message}</h3>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon">
                                        <img class="avatar img-fluid" src='${url}' alt='profile-img' width='100' height='100'>
                                    </div>
                                    <div class="title">Student profile</div>
                                    <div class="subtitle">Image</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/name.png" alt=""></div>
                                    <div class="title">${name}</div>
                                    <div class="subtitle">Name</div>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/rollno.png" alt=""></div>
                                    <div class="title">${rollNo}</div>
                                    <div class="subtitle">Roll No</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/dept.png" alt=""></div>
                                    <div class="title">${dept}</div>
                                    <div class="subtitle">Department</div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/room.png" alt=""></div>
                                    <div class="title">${roomNo}</div>
                                    <div class="subtitle">Room No</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/hostel.png" alt=""></div>
                                    <div class="title">${hostel}</div>
                                    <div class="subtitle">Hostel</div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/address.png" alt=""></div>
                                    <div class="title">${address}</div>
                                    <div class="subtitle">Address</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/from.png" alt=""></div>
                                    <div class="title">${timeLeave} | ${dateLeave}</div>
                                    <div class="subtitle">From</div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/to.png" alt=""></div>
                                    <div class="title">${timeEnter} | ${dateEnter}</div>
                                    <div class="subtitle">To</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-md-12 mt-1">
                                <div class="box">
                                    <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/approvedby.png" alt=""></div>
                                    <div class="title">${acceptedBy}</div>
                                    <div class="subtitle">Accepted by</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                } else if (response.status.action === "failure") {
                    const myElement = document.getElementById("entry-container");
                    myElement.innerHTML = " ";
                    myElement.innerHTML = `
                <style>
                    .container-1 {
                        max-width: 95%;
                        margin: 5px auto;
                        border: 1px solid #ccc;
                        padding: 20px;
                        background-color: white;
                    }
                    .box {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        border: 1px solid #ccc;
                        padding: 20px;
                        border-radius: 1px;
                        text-align: center;
                        background-color: #fafafa;
                    }
                    .box .icon {
                        font-size: 1.5em;
                        margin-bottom: 10px;
                    }
                    .box .title {
                        font-weight: bold;
                    }
                    .box .subtitle {
                        color: gray;
                    }
                    @media (max-width: 768px) {
                        .mt-6 {
                            margin-top: 90px !important;
                        }
                    }
                </style>
                <div class="container-fluid col-lg-12 col-md-12 mt-3 mb-2 w-100">
                    <div class="box">
                        <div class="icon mb-2"><img style="width: 40px;height:40px;" src="/images/layout-image/download.png" alt=""></div>
                        <div class="title mb-2">
                            <button class="btn btn-danger fs-5 rounded-1">${response.status.Message}</button>
                        </div>
                        <div class="title mb-2">
                            <button class="btn btn-dark rounded-1" onclick="window.location.reload();">Click to scan next QR</button>
                        </div>
                        <div class="subtitle">Scan the next QR</div>
                    </div>
                </div>
                `;

                } else {
                    alert("Something went wrong, scanning next QR code...");
                }
            },
            error: function () {
                alert("An error occurred, scanning next QR code...");
            },

        });
    })


    function onScanSuccess(decodeText, decodeResult) {
        htmlscanner.clear()
        $("#scan-container").hide();
        $("#entry-container").show();
        $("#qr-url").val(decodeText)

    }

    // Initialize the QR code scanner after a delay of 7 seconds
    htmlscanner.render(onScanSuccess);

});

