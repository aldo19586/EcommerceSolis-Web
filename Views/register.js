$(document).ready(function () {
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

  //<!-- Funcion de las validacions -->
  var funcion;
  $.validator.setDefaults({
    submitHandler: function () {
      //traer datos para registrar
      let username = $("#username").val();
      let pass = $("#pass").val();
      let nombres = $("#nombres").val();
      let apellidos = $("#apellidos").val();
      let dni = $("#dni").val();
      let email = $("#email").val();
      let telefono = $("#telefono").val();
      funcion = "registrarUsuario";
      //enviar datos
      $.post(
        "../Controllers/UserController.php",
        { username, pass, nombres, apellidos, dni, email, telefono, funcion },
        (response) => {
          if (response == "success") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Se ah registrado correctamente",
              showConfirmButton: false,
              timer: 3000,
            }).then(function () {
              $("#form-register").trigger("reset");
              location.href = "../Views/login.php";
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Hubo conflicto al registrarse, comuniquese con el area de sistemas",
            });
          }
        }
      );
    },
  });
  //Validacion Personalizadas
  //Nombres y Apellidos
  jQuery.validator.addMethod(
    "letras",
    function (value, element) {
      let variable = value.replace(/ /g, "");
      return /^[ A-Za-z]+$/.test(variable);
    },

    "*Este campo solo permite letras."
  );
  //Username
  jQuery.validator.addMethod(
    "usuarioExistente",
    function (value, element) {
      let funcion = "verificarUsuario";
      let bandera;
      $.ajax({
        type: "POST",
        url: "../Controllers/UserController.php",
        data: "funcion=" + funcion + "&&value=" + value,
        async: false,
        success: function (response) {
          if (response == "success") {
            bandera = false;
          } else {
            bandera = true;
          }
        },
      });
      console.log(bandera);
      return bandera;
    },
    "El usuario ya existe, por favor ingrese uno diferente"
  );
  /*Validaciones de REGISTRO*/
  $("#form-register").validate({
    rules: {
      nombres: {
        required: true,
        letras: true,
      },
      apellidos: {
        required: true,
        letras: true,
      },
      username: {
        required: true,
        minlength: 8,
        maxlength: 20,
        usuarioExistente: true,
      },
      pass: {
        required: true,
        minlength: 8,
        maxlength: 15,
      },
      pass_repeat: {
        required: true,
        equalTo: "#pass",
      },
      dni: {
        required: true,
        digits: true,
        minlength: 8,
        maxlength: 8,
      },
      email: {
        required: true,
        email: true,
      },
      telefono: {
        required: true,
        digits: true,
        minlength: 9,
        maxlength: 9,
      },
      terms: {
        required: true,
      },
    },
    messages: {
      username: {
        required: "*Este campo de obligatorio",
        minlength: "*El username debe ser de mínimo 8 caracteres",
        maxlength: "*El username debe ser de máximo 20 caracteres",
      },
      pass: {
        required: "*Este campo es obligatorio",
        minlength: "*El password debe ser de minimo 8 caracteres",
        maxlength: "*El username debe ser de máximo 15 caracteres",
      },
      pass_repeat: {
        required: "*Este campo es obligatorio",
        equalTo: "*El password no coincide con el ingresado",
      },
      nombres: {
        required: "*Este campo es obligatorio",
      },
      apellidos: {
        required: "*Este campo es obligatorio",
      },
      dni: {
        required: "*Este campo es obligatorio",
        minlength: "*El DNI debe ser de minimo 8 caracteres",
        maxlength: "*El DNI debe ser de máximo 8 caracteres",
        digits: "*El DNI solo esta compuesto por numeros.",
      },
      email: {
        required: "*Este campo es obligatorio",
        email: "*No es formato email",
      },
      telefono: {
        required: "*Este campo es obligatorio",
        minlength: "*El telefono debe ser de minimo 9 caracteres",
        maxlength: "*El telefono debe ser de máximo 9 caracteres",
        digits: "*El telefono solo esta compuesto por numeros.",
      },
      terms: "Por favor acepte los terminos",
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
      $(element).removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
      $(element).addClass("is-valid");
    },
  });
});
