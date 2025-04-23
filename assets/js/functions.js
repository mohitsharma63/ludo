// const base_url = "http://localhost/ludo/"
const base_url = "http://localhost/ludo/"
$("input").attr("autocomplete", "off");

$(document).on("click", ".showloader", function () {
  $("#loader").show();
});

function playsound() {
  document.getElementById("notsound").play();
}

$(document).on("submit", ".showloader-form", function () {
  $("#loader").show();
});

$(".showloader-form").submit(function () {
  $("#loader").show();
});

$(".copy").click(function () {
  var old = $(this).html();
  $(this).html('<i class="bi bi-hand-thumbs-up-fill"></i> Copied !');
  var btn = this;
  setTimeout(function () {
    $(btn).html(old);
  }, 1000);

  const text = $(this).data("text");
  window.navigator.clipboard
    .writeText(text)
    .then(function () {
      console.log("Text copied to clipboard");
    })
    .catch(function (err) {
      console.error("Could not copy text: ", err);
    });
});

$(".mobile_no_input").keypress(function (e) {
  let mobile_no = $(this).val();

  $(this).val(mobile_no.slice(0, 9));
});

$("#closenotification").click(function () {
  $("#notification").remove();
});

$(".aadhar_no_input").keypress(function (e) {
  let mobile_no = $(this).val();

  $(this).val(mobile_no.slice(0, 11));
});

$(".otp_input").keypress(function (e) {
  let otp = $(this).val();

  $(this).val(otp.slice(0, 5));
});

const info = (message) => {
  Swal.fire({
    title: "",
    text: message,
    icon: "info",
    confirmButtonText: "OK",
    toast: true,
    confirmButtonColor: "#FFA41F",
  });
};

const done = (message) => {
  Swal.fire({
    title: "",
    text: message,
    icon: "success",
    confirmButtonText: "OK",
    toast: true,
    confirmButtonColor: "#FFA41F",
  });
};

const error = (message) => {
  Swal.fire({
    title: "",
    text: message,
    icon: "error",
    confirmButtonText: "OK",
    toast: true,
    confirmButtonColor: "#FFA41F",
  });
};
