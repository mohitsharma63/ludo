function online() {
  $.ajax({
    type: "POST",
    url: base_url + "user/online",
    success: function (data) {},
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
    },
  });
}

$(function () {
  setInterval(() => {
    online();
  }, 1500);
});
