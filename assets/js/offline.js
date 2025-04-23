function offline() {
  $.ajax({
    type: "POST",
    url: base_url + "user/offline",
    success: function (data) {},
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
    },
  });
}

$(function () {
  setInterval(() => {
    offline();
  }, 10000);
});
