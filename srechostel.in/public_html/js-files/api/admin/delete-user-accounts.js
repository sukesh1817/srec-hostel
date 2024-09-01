$(document).ready(function () {
    $("#single-form").submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "DELETE",
            url: "/api/accounts/delete_user_account/",
            data: {
                roll_no: $("#roll_no").val(),
            },
            // dataType: "json",
            success: function (data) {
                console.log("done")
            },
            
        });
    });
});