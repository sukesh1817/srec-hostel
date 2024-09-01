$(document).ready(function () {
    $("#single-form").submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/accounts/delete_user_account/",
            data: {
                user_id: $("#user_id").val(),
            },
            // dataType: "json",
            success: function (data) {
                console.log("done")
            },
            
        });
    });
});