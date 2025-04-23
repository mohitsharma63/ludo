var pdone = false;
$(function () {
  function verifypayment() {
    if (pdone) return;
    $.ajax({
      method: "post",
      url: base_url + "user/verifyupipayment",
      dataType: "json",
      data: { xox: true },
      success: function (res) {
        console.log(res);
        if (res.status == "success") {
          pdone = true;
          $("#paymentpendingmsg").hide();
          $("#paymentsuccessmsg").show();

          window.location.href = base_url + "user/wallet";
          $("#loading").show();
        }
        setTimeout(() => {
          verifypayment();
        }, 1000);
      },
      error: function (response, status, error_msg) {
        console.log(response);
        error(status.toUpperCase() + " : " + error_msg);
      },
    });
  }

  verifypayment();
});
