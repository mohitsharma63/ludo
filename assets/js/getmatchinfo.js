var ajaxIsRunning4 = false;
var matchdata = null;

function getMatch() {
  if (ajaxIsRunning4) return;
  ajaxIsRunning4 = true;

  $.ajax({
    type: "POST",
    url: actionUrlForMatch,
    success: function (data) {
      console.log(data);
      if (matchdata == null) {
        matchdata = data;
      } else {
        if (matchdata != data) {
          playsound();
          location.reload();
          return;
        }
      }

      ajaxIsRunning4 = false;
    },
    error: function (response, status, error_msg) {
      error(status.toUpperCase() + " : " + error_msg);
    },
  });
}

setInterval(() => {
  getMatch();
}, 500);

getMatch();
