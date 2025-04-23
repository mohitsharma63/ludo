$(".fetchform").submit(function (e) {
  $("#fetchloader").show();
  e.preventDefault();
  let form = $(this);
  let actionUrl = form.attr("action");
  let id = form.attr("id");
  $("#i_show_fetch_data").html("");
  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(), // serializes the form's elements
    success: function (data) {
      if (data) {
        $("#i_show_fetch_data").html(data);
      } else {
        $("#i_show_fetch_data").html(
          '<div class="text-danger text-center">no data available</div>'
        );
      }
      $("#fetchloader").hide();
    },
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
      $("#fetchloader").hide();
    },
  });
});

$(".filter").click(function () {
  $(".filter").attr("class", "btn btn-outline-primary btn-sm filter");
  $(this).attr("class", "btn btn-primary btn-sm filter");
});
