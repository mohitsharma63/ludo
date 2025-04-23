var ajaxIsRunning = false;
var page = 1;
function iload() {
  if (ajaxIsRunning) return;
  ajaxIsRunning = true;

  $.ajax({
    type: "POST",
    url: i_load_url + "/" + page,
    success: function (data) {
      if (data) {
        $("#i_load_data").append(data);
        ajaxIsRunning = false;
        page++;
        iload();
      } else {
        if (page == 1) {
          $("#i_load_data").append(
            ' <div class="text-center my-3 text-gold">no data available</div>'
          );
        }
      }
    },
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
    },
  });
}

$(function () {
  iload();
});

// $(window).scroll(function () {
//   alert("sds");
//   if ($(window).scrollTop() + $(window).height() > $(document).height() - 250) {
//     if (!ajaxIsRunning) iload();
//   }
// });
