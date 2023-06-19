$(document).ready(function () {
  var funcion;
  /*Verificar la Sesion*/
  verificarSesion();
  function verificarSesion() {
    funcion = "verificarSesion";
    $.post("../Controllers/UserController.php", { funcion }, (response) => {
      if (response != "") {
        location.href = "../index.php";
      }
    });
  }

  /*Iniciar Sesion*/
  $("#form-login").submit((e) => {
    funcion = "login";
    let user = $("#user").val();
    let pass = $("#pass").val();
    $.post(
      "../Controllers/UserController.php",
      { user, pass, funcion },
      (response) => {
        console.log(response);
        if (response == "logueado") {
          toastr.success("Iniciado correctamente!");
          location.href = "../index.php";
        } else {
          toastr.error(" Usuario o contraseña incorrectas!");
        }
      }
    );
    e.preventDefault();
  });
});
