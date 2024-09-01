$(document).ready(function () {
    const successToast = document.getElementById('toast-success');
    const errorToast = document.getElementById('toast-error');

    // Hide both toasts first
    successToast.classList.remove('show');
    successToast.classList.add('hidden');
    errorToast.classList.remove('show');
    errorToast.classList.add('hidden');

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
                if (data['code'] == 1) {
                    successToast.classList.remove('hidden');
                    successToast.classList.add('show');
                } else {
                    errorToast.classList.remove('hidden');
                    errorToast.classList.add('show');
                }

                setTimeout(() => {
                    if (data["code"] == 1) {
                        successToast.classList.remove('show');
                        successToast.classList.add('hidden');
                    } else if (data["code"] == 0) {
                        errorToast.classList.remove('show');
                        errorToast.classList.add('hidden');
                    }
                }, 3000);
            },

        });
    });
});


