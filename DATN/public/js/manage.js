function deleteModal() {
  var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
  let id = event.target.parentNode.parentNode.parentNode.id;
  const data = document.getElementById(id).querySelectorAll(".row-data");
  $("#user-name").text(`${data[0].innerHTML} ${data[1].innerHTML}`);
  $("#user-email").text(`${data[2].innerHTML}`);
  myModal.show();
}

function onDelete() {
  $("#modal-submit").prop("disabled", true);
  let email = $("#user-email").text();
  $.ajax({
    type: "POST",
    url: "../app/controllers/delete.php",
    data: {
      email,
    },
    dataType: "json",
    encode: true,
  }).done(function (data) {
    $("#loading").addClass("spinner-border");
    if (data.success) {
      setTimeout(() => {
        $("#modal-close").click();
        location.reload();
        $("#loading").removeClass("spinner-border");
        $("#modal-submit").prop("disabled", false);
      }, 1000);
    }
  });
}

(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );
})();

var ID = 0;

function onEdit() {
  var myModal = new bootstrap.Modal(document.getElementById("edit-modal"));
  let id = event.target.parentNode.parentNode.parentNode.id;
  ID = document.getElementById(id).getAttribute("name");
  const data = document.getElementById(id).querySelectorAll(".row-data");
  $("#modal-first").attr("value", `${data[0].innerHTML}`);
  $("#modal-last").attr("value", `${data[1].innerHTML}`);
  $("#modal-email").attr("value", `${data[2].innerHTML}`);
  data[3].innerHTML == "User"
    ? $("#admin").prop("checked", false)
    : $("#admin").prop("checked", true);
  myModal.show();
}
function clickSave() {
  let email = $("#modal-email").val();
  let last = $("#modal-last").val();
  let first = $("#modal-first").val();
  let role = $("#admin").prop("checked") ? 1 : 0;
  $.ajax({
    type: "POST",
    url: "../app/controllers/update.php",
    data: {
      id: ID,
      email,
      last,
      first,
      role
    },
    dataType: "json",
    encode: true,
  })
    .done(function (data) {
      $("#modal-loading").addClass("spinner-border");
      if (data.success) {
        setTimeout(() => {
          $("#modal2-close").click();
          location.reload();
          $("#modal-loading").removeClass("spinner-border");
          document
            .getElementsByTagName("fieldset")[0]
            .setAttribute("disabled", true);
          let type = document.getElementById("save");
          type.innerHTML = "Sửa";
        }, 1000);
      } else {
        $("#modal-alert").html(`
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div>
                                ${data.errors.empty_field}
                                </div>
                                </div>`);
        $("#modal-loading").removeClass("spinner-border");
      }
    })
    .catch((err) => console.log(err));
}
function clickEdit() {
  let fieldset = document.getElementsByTagName("fieldset")[0];
  fieldset.removeAttribute("disabled");
  let type = document.getElementById("save");
  type.innerHTML = "Lưu";
}
