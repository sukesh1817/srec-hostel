$(document).ready(function () {
  $("#log-in-form").submit(function (event) {
    event.preventDefault();
      // Disable the Google OAuth link
      document.getElementById('oauth').classList.add('disabled');
      document.getElementById('oauth').style.pointerEvents = 'none';

      // Disable form fields
      document.getElementById('username').disabled = true;
      document.getElementById('password').disabled = true;
    const spinner = document.getElementById("loader");
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
          let subdomain = data['Whois'].toLowerCase() + ".srechostel.in";
          window.location.replace(`https://${subdomain}`);
        } else {

          $("#btn-log").attr("disabled", "disabled");
          var show = function () {
            var toastElList = [].slice.call(
              document.querySelectorAll(".toast")
            );
            spinner.style.display = "none";
            var toastList = toastElList.map(function (toastEl) {
              return new bootstrap.Toast(toastEl);
            });
            toastList.forEach((toast) => toast.show());
            var rmattr = () => {
              $("#btn-log").removeAttr("disabled");
              document.getElementById('username').disabled = false;
              document.getElementById('password').disabled = false;
              oauthButton.classList.remove('disabled');
              oauthButton.style.pointerEvents = 'auto';
            };
            setTimeout(rmattr, 1000);
          };
          setTimeout(show, 3000);
        }
      },
    });
  });
});
