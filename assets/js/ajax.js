$(".ajaxform").submit(function (e) {
  $("#loader").show();
  e.preventDefault();
  let form = $(this);
  let actionUrl = form.attr("action");
  let id = form.attr("id");

  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(), // serializes the form's elements.
    dataType: "json",
    success: function (data) {
      console.log(data, id);
      if (data.status) {
        if (data.msg) done(data.msg);

        if (id == "signup_form" || id == "login_form") {
          location.href = base_url + "verify-otp";
        } else if (id == "verifyotp_form") {
          location.href = base_url + "home";
        } else if (id == "updatebank") {
          $("#loader").hide();
        } else if (id == "withdraw") {
          window.location.href = data.gotourl;
        } else if (id == "adminlogin") {
          location.reload();
        } else if (id == "addtxnform") {
          $("#loader").hide();

          form[0].reset();

          $("#allform").submit();
        } else {
          $("#loader").hide();

          form[0].reset();
        }
      } else {
        info(data.msg);
        $("#loader").hide();
        if (id == "verifyotp_form") {
          form[0].reset();
        }
      }
    },
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
      $("#loader").hide();
    },
  });
});
