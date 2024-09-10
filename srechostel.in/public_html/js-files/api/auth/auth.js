$(document).ready(function () {
  $("#log-in-form").submit(function (event) {
    event.preventDefault();
    const spinner =  document.getElementById("loader");
    spinner.style.removeProperty("display");
    $.ajax({
      type: "POST",
      url: "/api/auth/login/",
      data: {
        username: $("#username").val(),
        password: $("#password").val(),
      },
      success: function (data) {
        if (data['Message'] === "success") {
          $("#btn-log").attr("disabled", "disabled");
          setTimeout(window.location.reload(), 5000);
        } else {

          $("#btn-log").attr("disabled", "disabled");
          var show = function () {
            var toastElList = [].slice.call(
              document.querySelectorAll(".toast")
            );
            spinner.style.display="none";
            var toastList = toastElList.map(function (toastEl) {
              return new bootstrap.Toast(toastEl);
            });
            toastList.forEach((toast) => toast.show());
            var rmattr = () => {
              $("#btn-log").removeAttr("disabled");
            };
            setTimeout(rmattr, 1000);
          };
          setTimeout(show, 3000);
        }
      },
    });
  });
});
