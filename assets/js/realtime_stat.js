var ddd_data = {
  onlineusers: 0,
  withdraws: 0,
  conflicts: 0,
  kycs: 0,
  activematches: 0,
  cancels: 0,
};
function astat() {
  $.ajax({
    type: "POST",
    url: base_url + "admin/stat",
    dataType: "json",
    success: function (data) {
      if (
        ddd_data.withdraws != data.withdraws ||
        ddd_data.conflicts != data.conflicts ||
        ddd_data.kycs != data.kycs ||
        ddd_data.cancels != data.cancels
      ) {
        playsound();
        ddd_data.withdraws = data.withdraws;
        ddd_data.conflicts = data.conflicts;
        ddd_data.kycs = data.kycs;
        ddd_data.activematches = data.activematches;
        ddd_data.cancels = data.cancels;
      }
      $("#onlineusers").text(data.onlineusers);
      $("#withdraws").text(data.withdraws);
      $("#conflicts").text(data.conflicts);
      $("#kycs").text(data.kycs);
      $("#activematches").text(data.activematches);
      $("#cancels").text(data.cancels);

      if (data.onlineusers > 0) {
        $("#onlineusers").parent().addClass("bg-success text-white");
      } else {
        $("#onlineusers").parent().removeClass("bg-success text-white");
      }

      if (data.withdraws > 0) {
        $("#withdraws").parent().addClass("bg-success text-white");
      } else {
        $("#withdraws").parent().removeClass("bg-success text-white");
      }

      if (data.conflicts > 0) {
        $("#conflicts").parent().addClass("bg-success text-white");
      } else {
        $("#conflicts").parent().removeClass("bg-success text-white");
      }

      if (data.kycs > 0) {
        $("#kycs").parent().addClass("bg-success text-white");
      } else {
        $("#kycs").parent().removeClass("bg-success text-white");
      }

      if (data.activematches > 0) {
        $("#activematches").parent().addClass("bg-success text-white");
      } else {
        $("#activematches").parent().removeClass("bg-success text-white");
      }

      if (data.cancels > 0) {
        $("#cancels").parent().addClass("bg-success text-white");
      } else {
        $("#cancels").parent().removeClass("bg-success text-white");
      }

      setTimeout(() => {
        astat();
      }, 1000);
    },
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
    },
  });
}

$(function () {
  astat();
});
