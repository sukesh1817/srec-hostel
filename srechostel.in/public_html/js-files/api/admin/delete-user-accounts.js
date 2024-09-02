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
            dataType: "json",
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
                }, 5000);
            },

        });
    });







    $("#roll-nos-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/accounts/delete_user_account/",
            data: {
                group_of_roll_no: $("#rollNumbers").val(),
            },
            dataType: "json",
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
                }, 5000);
            },

        });
    });




    $("#year-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/accounts/delete_user_account/",
            data: {
                year: $("#year_only").val(),
            },
            dataType: "json",
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
                }, 5000);
            },

        });
    });





    $("#dept-year-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/api/accounts/delete_user_account/",
            data: {
                dept: $("#dept_group").val(),
                year: $("#year_group").val()
            },
            dataType: "json",
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
                }, 5000);
            },

        });
    });
});


