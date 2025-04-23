var ajaxIsRunning2 = false;
var page2 = 1;
function iload2() {
  if (ajaxIsRunning2) return;
  ajaxIsRunning2 = true;

  $.ajax({
    type: "POST",
    url: i_load_url2 + "/" + page2,
    success: function (data) {
      if (data) {
        $("#i_load_data2").append(data);
        ajaxIsRunning2 = false;
        page2++;
        iload2();
      } else {
        if (page2 == 1) {
          $("#i_load_data2").append(
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
  iload2();
});

// $(window).scroll(function () {
//   alert("sds");
//   if (
//     $(window).scrollTop() + $(window).height() >
//     $(document).height() - 1000
//   ) {
//     if (!ajaxIsRunning2) iload2();
//   }
// });
