$(document).ready(function () {
    $("#form-committee").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/committee/add/",
            data: {
                roll_no: $("#roll_no").val(),
                which_committee: $("#which_committee").val(),
            },
            dataType: "json",
            success: function (data) {
                if (data['Message'] === "Success") {
                    var icons = `
                     <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" class="me-1" height="40"
                            viewBox="0 0 48 48">
                            <path fill="#4caf50"
                                d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                            <path fill="#ccff90"
                                d="M34.602,14.602L21,28.199l-5.602-5.598l-2.797,2.797L21,33.801l16.398-16.402L34.602,14.602z">
                            </path>
                        </svg>
                        <strong class="me-auto">Data Added successfully</strong>
                        <small class="me-1 ms-1">Just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>

                    `;
                    var message = `Committee member added successfully please check it.`;
                    document.getElementById("toast-icon").innerHTML = icons
                    document.getElementById("toast-message").innerHTML = message
                    const toastTrigger = document.getElementById('liveToastBtn')
                    const toastLiveExample = document.getElementById('liveToast')
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                    toastBootstrap.show()
                } else {
                    var icons = `
                   <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="me-1" width="40" height="40" viewBox="0 0 48 48">
    <path fill="#F44336" d="M21.5 4.5H26.501V43.5H21.5z" transform="rotate(45.001 24 24)"></path><path fill="#F44336" d="M21.5 4.5H26.5V43.501H21.5z" transform="rotate(135.008 24 24)"></path>
    </svg>
                       <strong class="me-auto">Data Added Failed</strong>
                        <small class="me-3 ms-2">Just now</small>


                     <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>

                   `;
                    var message = `Committee member added Failed, Something went wrong.`;
                    document.getElementById("toast-icon").innerHTML = icons
                    document.getElementById("toast-message").innerHTML = message
                    const toastTrigger = document.getElementById('liveToastBtn')
                    const toastLiveExample = document.getElementById('liveToast')
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                    toastBootstrap.show()

                }
            },
        });
    });

});
