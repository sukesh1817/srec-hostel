$("#entry-btn").click(function () {
    const url = $qrUrl.val();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (response) {
            const { action, Message } = response.status;
            const details = response.details;
            const fields = {
                name: 'Name',
                rollNo: 'Roll No',
                roomNo: 'Room No',
                dept: 'Department',
                hostel: 'Hostel',
                address: 'Address',
                timeLeave: 'From',
                dateLeave: '',
                timeEnter: 'To',
                dateEnter: '',
                acceptedBy: 'Accepted by'
            };

            let content = `
                <style>
                    .container-1 { max-width: 95%; margin: 5px auto; border: 1px solid #ccc; padding: 20px; background-color: white; }
                    .box { display: flex; flex-direction: column; align-items: center; border: 1px solid #ccc; padding: 20px; border-radius: 1px; text-align: center; background-color: #fafafa; }
                    .box .icon { font-size: 1.5em; margin-bottom: 10px; }
                    .box .title { font-weight: bold; }
                    .box .subtitle { color: gray; }
                    @media (max-width: 768px) { .mt-6 { margin-top: 90px !important; } }
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
            `;

            if (action === "success" && ["Successfully Checkin", "Successfully Checkout"].includes(Message)) {
                content += `
                    <div id="html-content">
                        <div class="container-1">
                            <h3 class="text-center title fw-bold">${details.passType} ${Message}</h3>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-md-12 mt-1">
                                    <div class="box">
                                        <div class="icon"><img class="avatar img-fluid" src="${details.profile_url}" alt="profile-img" width="100" height="100"></div>
                                        <div class="title">Student profile</div>
                                        <div class="subtitle">Image</div>
                                    </div>
                                </div>
                            </div>
                            ${Object.entries(fields).map(([key, label]) => `
                                <div class="row">
                                    <div class="col-lg-6 mt-1">
                                        <div class="box">
                                            <div class="icon"><img style="width: 40px;height:40px;" src="/images/layout-image/${key}.png" alt=""></div>
                                            <div class="title">${details[key] || ''}</div>
                                            <div class="subtitle">${label}</div>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else if (action === "failure") {
                content += `
                    <div class="container-fluid col-lg-12 col-md-12 mt-3 mb-2 w-100">
                        <div class="box">
                            <div class="icon mb-2"><img style="width: 40px;height:40px;" src="/images/layout-image/download.png" alt=""></div>
                            <div class="title mb-2">
                                <button class="btn btn-danger fs-5 rounded-1">${Message}</button>
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

            $entryContainer.html(content).show();
        },
        error: function () {
            alert("An error occurred, scanning next QR code...");
        }
    });
});
