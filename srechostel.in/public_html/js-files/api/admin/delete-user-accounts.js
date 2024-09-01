$(document).ready(function () {
    $("#single-form").submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/accounts/delete_user_account/",
            data: {
                roll_no: $("#user_id").val(),
            },
            // dataType: "json",
            success: function (data) {
                console.log("done")
            },
            
        });
    });
});