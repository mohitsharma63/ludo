var ajaxIsRunning3 = false;
var matchrecords = null;
function loadmatches() {
  if (ajaxIsRunning3) return;
  ajaxIsRunning3 = true;

  $.ajax({
    type: "POST",
    url: actionUrlForMatches,
    success: function (data) {
      $("#matchdata").html(data);
      fetchBalance();
      ajaxIsRunning3 = false;
      if (matchrecords != data) {
        playsound();
        matchrecords = data;
      }
    },
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
    },
  });
}

setInterval(() => {
  loadmatches();
}, 500);

function fetchBalance() {
  $.ajax({
    type: "POST",
    url: base_url + "user/fetchBalance",
    success: function (data) {
      $("#balance").text(data);
    },
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
    },
  });
}

loadmatches();
