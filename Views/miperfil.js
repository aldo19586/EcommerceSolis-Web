$(document).ready(function () {
  var funcion;
  /*Para q pueda funcionar el input de enviar archivo desde un formulario */
  bsCustomFileInput.init();
  /*Verificar la Sesion - Obtener datos */
  verificarSesion();
  obtenerDatos();
  llenarDepartamento();
  obtenerDatosDirecciones();
  llenarHistorial();
  //FUNCION PARA LEER LAS NOTIFICACIONES
  async function readNotificaciones() {
    funcion = "readNotificaciones";
    //Otra forma de enviar datos POST
    let data = await fetch("../Controllers/NotificacionController.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "funcion=" + funcion,
    });
    if (data.ok) {
      let response = await data.text();
      try {
        let notificaciones = JSON.parse(response);
        console.log(notificaciones);
        let template1 = "";
        let template2 = "";
        //ESTRUCTURA DE LAS NOTIFICACIONES
        //Verificar si el usuario tiene notificaciones o no
        if (notificaciones.length == 0) {
          template1 += `<i class="fas fa-bell"></i>`;
          template2 += `Notificaciones`;
        } else {
          template1 += `<i class="fas fa-bell"></i>
            <span class="badge badge-warning navbar-badge">${notificaciones.length}</span>`;
          template2 += `Notificaciones<span class="badge badge-warning right">${notificaciones.length}</span>`;
        }
        $("#numero_notificacion").html(template1);
        $("#nav_cont_noti").html(template2);

        let template = "";
        template += `<span class="dropdown-item dropdown-header">${notificaciones.length} Notificaciones</span>`;

        notificaciones.forEach((notificacion) => {
          template += `<div class="dropdown-divider"></div>
                          <a href="../${notificacion.url_1}&&noti=${notificacion.id}" class="dropdown-item">
                          <div class="media">
                              <img src="../Util/Img/Products/${notificacion.imagen}" alt="User Avatar"
                                  class="img-size-50 img-circle mr-3">
                              <div class="media-body">
                                  <h3 class="dropdown-item-title">
                                      ${notificacion.titulo}
                                      
                                  </h3>
                                  <p class="text-sm">${notificacion.asunto}
                                  <p class="text-sm text-muted">${notificacion.contenido}</p>
                                  <span class="float-right text-muted text-sm">${notificacion.fecha_creacion}</span>
                              </div>
                          </div>
                      </a>`;
        });
        template += `<a href="../Views/notificaciones.php" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>`;

        $("#notificaciones").html(template);
      } catch (error) {
        console.error(error);

        console.log(response);
      }
    } else {
      Swal.fire({
        icon: "error",
        title: data.statusText,
        text: "Hubo conflicto de codigo: " + data.status,
      });
    }
  }
  /*Select2 para AGREGAR DIRECCION*/
  $("#departamento").select2({
    placeholder: "Seleccione un departamento",
    language: {
      noResults: function () {
        return "No hay resultado";
      },
      searching: function () {
        return "Buscando..";
      },
    },
  });
  $("#provincia").select2({
    placeholder: "Seleccione una provincia",
    language: {
      noResults: function () {
        return "No hay resultado";
      },
      searching: function () {
        return "Buscando..";
      },
    },
  });
  $("#distrito").select2({
    placeholder: "Seleccione un distrito",
    language: {
      noResults: function () {
        return "No hay resultado";
      },
      searching: function () {
        return "Buscando..";
      },
    },
  });

  /*Obtener datos para llenar el formulario de direcciones*/
  function obtenerDatosDirecciones() {
    funcion = "obtenerDatosDirecciones";
    $.post(
      "../Controllers/UserDistrictController.php",
      { funcion },
      (response) => {
        console.log(response);
        let direcciones = JSON.parse(response);
        let contador = 0;
        let template = "";
        direcciones.forEach((direccion) => {
          contador++;
          template += `
          <div class="callout callout-info">
            <div class="card-header">
              <strong>Direccion ${contador}</strong>
                <div class="card-tools">
                  <button type="button" dir_id="${direccion.id}" class="eliminar_direccion btn btn-tool">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
            </div>
            <div class="card-body">
            <h2 class="lead"><b>${direccion.direccion}</b></h2>
                                <p class="text-muted text-sm"><b>Referencia: </b>${direccion.referencia}</p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                                    </li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                        ${direccion.distrito}/${direccion.provincia}/${direccion.departamento}

                                    </li>
                                </ul>
            </div>
          </div>

          `;
        });
        $("#direcciones").html(template);
        obtenerDatos();
      }
    );
  }
  /*Eliminar direcciones*/
  $(document).on("click", ".eliminar_direccion", (e) => {
    let elemento = $(this)[0].activeElement;
    let id = $(elemento).attr("dir_id");
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success m-3",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });

    swalWithBootstrapButtons
      .fire({
        title: "Desea borrar esta direccion?",
        text: "Esta accion puede traer consecuencias",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, borra esto!",
        cancelButtonText: "No, deseo cancelar!",
        reverseButtons: true,
      })
      .then((result) => {
        if (result.isConfirmed) {
          funcion = "eliminarDireccion";
          $.post(
            "../Controllers/UserDistrictController.php",
            { funcion, id },
            (response) => {
              if (response == "success") {
                swalWithBootstrapButtons.fire(
                  "Borrado",
                  "La direccion fue borrada",
                  "success"
                );
                obtenerDatosDirecciones();
                llenarHistorial();
              } else if (response == "error") {
                swalWithBootstrapButtons.fire(
                  "No se borró",
                  "Hubo alteraciones en la integridad de datos",
                  "error"
                );
              } else {
                swalWithBootstrapButtons.fire(
                  "No se ah borrado",
                  "Tenemos problemas en el sistema",
                  "error"
                );
              }
            }
          );
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire(
            "Cancelado",
            "La direccion no se borro",
            "error"
          );
        }
      });
  });
  /*Funcion para llenar el historial*/
  function llenarHistorial() {
    funcion = "llenarHistorial";
    $.post(
      "../Controllers/HistorialController.php",
      { funcion },
      (response) => {
        let historiales = JSON.parse(response);
        //console.log(historiales);
        let template = "";
        historiales.forEach((historial) => {
          template += `
          <div class="time-label">
              <span class="bg-danger">
                     ${historial[0].fecha}
              </span>
          </div>
          `;
          historial.forEach((cambio) => {
            let cambio_tipo_historial = cambio.tipo_historial.toLowerCase();
            let cambio_modulo = cambio.modulo.toLowerCase();
            template += `
            <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                           ${cambio.m_icono}

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> ${cambio.hora}</span>

                                                <h3 class="timeline-header">${cambio.th_icono}  Se realizó la accion ${cambio_tipo_historial} en ${cambio_modulo}</h3>
                                                </h3>

                                                <div class="timeline-body">
                                                    ${cambio.descripcion}
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
            `;
          });
        });
        template += `
        <!-- END timeline item -->
        <div>
            <i class="far fa-clock bg-gray"></i>
        </div>                   `;
        $("#historiales").html(template);
        obtenerDatosDirecciones();
      }
    );
  }
  /*Funcion para llenar los departaemntos*/
  function llenarDepartamento() {
    funcion = "llenarDepartamento";
    $.post(
      "../Controllers/DepartmentController.php",
      { funcion },
      (response) => {
        console.log(response);
        let departamentos = JSON.parse(response);
        let template = "";
        departamentos.forEach((departamento) => {
          template += `
          <option value="${departamento.id}">${departamento.nombre}</option>
          `;
        });
        $("#departamento").html(template);
        $("#departamento").val("").trigger("change");
      }
    );
  }
  /*Funcion para llenar las provincias*/
  $("#departamento").change(function () {
    let id_departamento = $("#departamento").val();
    funcion = "llenarProvincia";
    $.post(
      "../Controllers/ProvinceController.php",
      { funcion, id_departamento },
      (response) => {
        console.log(response);
        let provincias = JSON.parse(response);
        let template = "";
        provincias.forEach((provincia) => {
          template += `
          <option value="${provincia.id}">${provincia.nombre}</option>
          `;
        });
        $("#provincia").html(template);
        $("#provincia").val("").trigger("change");
      }
    );
  });
  /*Funcion para llenar los distritos*/
  $("#provincia").change(function () {
    let id_provincia = $("#provincia").val();
    funcion = "llenarDistrito";
    $.post(
      "../Controllers/DistrictController.php",
      { funcion, id_provincia },
      (response) => {
        console.log(response);
        let distritos = JSON.parse(response);
        let template = "";
        distritos.forEach((distrito) => {
          template += `
          <option value="${distrito.id}">${distrito.nombre}</option>
          `;
        });
        $("#distrito").html(template);
        $("#distrito").val("").trigger("change");
      }
    );
  });

  /*Verificar la Sesion - Reemplazar - Ocultar -etc*/
  function verificarSesion() {
    funcion = "verificarSesion";
    $.post("../Controllers/UserController.php", { funcion }, (response) => {
      console.log(response);
      if (response != "") {
        let sesion = JSON.parse(response);
        /*Recibir datos y colocar*/
        $("#nav_login").hide();
        $("#nav_register").hide();
        $("#usuario_nav").text(sesion.user + " #" + sesion.id);
        $("#avatar_nav").attr("src", "../Util/Img/Users/" + sesion.avatar);
        $("#avatar_menu").attr("src", "../Util/Img/Users/" + sesion.avatar);
        $("#usuario_menu").text(sesion.user);
        readNotificaciones();
        //Mostramos la campana de notificaciones cuando hay sesion
        $("#notificacion").show();
        $("#nav_notificaciones").show();
      } else {
        $("#nav_usuario").hide();
        $("#notificacion").hide();
        $("#nav_notificaciones").hide();
        location.href = "login.php";
      }
    });
  }
  /*Obtener datos para llenar el formulario de datos personales*/
  function obtenerDatos() {
    funcion = "obtenerDatos";
    $.post("../Controllers/UserController.php", { funcion }, (response) => {
      let usuario = JSON.parse(response);
      /*Recibir datos y colocar*/
      $("#username").text(usuario.username);
      $("#tipo_usuario").text(usuario.tipo_usuario);
      $("#nombres").text(usuario.nombres + " " + usuario.apellidos);
      $("#avatar_perfil").attr("src", "../Util/Img/Users/" + usuario.avatar);
      $("#dni").text(usuario.dni);
      $("#email").text(usuario.email);
      $("#telefono").text(usuario.telefono);
    });
  }
  /*Registrar datos de las direcciones*/
  $("#form-direccion").submit((e) => {
    funcion = "direccion";
    /*Atrapar los valores de datos y enviar*/
    let id_distrito = $("#distrito").val();
    let direccion = $("#direccion").val();
    let referencia = $("#referencia").val();
    $.post(
      "../Controllers/UserDistrictController.php",
      { id_distrito, direccion, referencia, funcion },
      (response) => {
        if (response == "success") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Se ah registrado tu direccion",
            showConfirmButton: false,
            timer: 2000,
          }).then(function () {
            $("#form-direccion").trigger("reset");
            $("#departamento").val("").trigger("change");
            llenarhistorial();
            obtenerDatosDirecciones();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo conflicto al crear su direccion,comuníquese con el area de sistemas",
          });
        }
      }
    );
    e.preventDefault();
  });

  /*Llenar en el modal los datos personales*/
  $(document).on("click", ".editar_datos", (e) => {
    funcion = "obtenerDatos";
    $.post("../Controllers/UserController.php", { funcion }, (response) => {
      console.log(response);
      /*Recibir datos*/
      //Con esto decodificamos
      let usuario = JSON.parse(response);
      $("#nombres_mod").val(usuario.nombres);
      $("#apellidos_mod").val(usuario.apellidos);
      $("#dni_mod").val(usuario.dni);
      $("#email_mod").val(usuario.email);
      $("#telefono_mod").val(usuario.telefono);
    });
  });

  $.validator.setDefaults({
    submitHandler: function () {
      /*Actualizar los datos personales con el avatar*/
      funcion = "editar_datos";
      //OTRA FORMA DE ENVIAR DATOS cuando tenemos q enviar imgs.
      let datos = new FormData($("#form-datos")[0]);
      datos.append("funcion", funcion);
      $.ajax({
        type: "POST",
        url: "../Controllers/UserController.php",
        data: datos,
        cache: false,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log(response);

          if (response == "success") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Se ah actualizado tu informacion correctamente",
              showConfirmButton: false,
              timer: 2000,
            }).then(function () {
              verificarSesion();
            });
            obtenerDatos();
            llenarHistorial();
          } else if (response == "danger") {
            Swal.fire({
              icon: "warning",
              title: "No alteró ningun cambio",
              text: "Modifique algun cambio para realizar la edición.",
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Hubo conflicto al crear sus datos,comuníquese con el area de sistemas",
            });
          }
        },
      });
      /*Actualizar los datos personales sin el avatar*/
      /*let nombres = $("#nombres_mod").val();
      let apellidos = $("#apellidos_mod").val();
      let dni = $("#dni_mod").val();
      let email = $("#email_mod").val();
      let telefono = $("#telefono_mod").val();
      $.post(
        "../Controllers/UserController.php",
        { funcion, nombres, apellidos, dni, email, telefono },
        (response) => {
          console.log(response);
          obtenerDatos();
          if (response == "success") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Se ah actualizado tu informacion correctamente",
              showConfirmButton: false,
              timer: 1000,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Hubo conflicto al crear su direccion,comuníquese con el area de sistemas",
            });
          }
        }
      );*/
    },
  });
  /*Validacion personalizada de editar datos personales*/
  jQuery.validator.addMethod(
    "letras",
    function (value, element) {
      let variable = value.replace(/ /g, "");
      return /^[ A-Za-z]+$/.test(variable);
    },

    "*Este campo solo permite letras."
  );
  /*Validacion del modal de editar datos personales*/
  $("#form-datos").validate({
    rules: {
      nombres_mod: {
        required: true,
        letras: true,
      },
      apellidos_mod: {
        required: true,
        letras: true,
      },
      dni_mod: {
        required: true,
        digits: true,
        minlength: 8,
        maxlength: 8,
      },
      email_mod: {
        required: true,
        email: true,
      },
      telefono_mod: {
        required: true,
        digits: true,
        minlength: 9,
        maxlength: 9,
      },
    },
    messages: {
      nombres_mod: {
        required: "*Este campo es obligatorio",
      },
      apellidos_mod: {
        required: "*Este campo es obligatorio",
      },
      dni_mod: {
        required: "*Este campo es obligatorio",
        minlength: "*El DNI debe ser de minimo 8 caracteres",
        maxlength: "*El DNI debe ser de máximo 8 caracteres",
        digits: "*El DNI solo esta compuesto por numeros.",
      },
      email_mod: {
        required: "*Este campo es obligatorio",
        email: "*No es formato email",
      },
      telefono_mod: {
        required: "*Este campo es obligatorio",
        minlength: "*El telefono debe ser de minimo 9 caracteres",
        maxlength: "*El telefono debe ser de máximo 9 caracteres",
        digits: "*El telefono solo esta compuesto por numeros.",
      },
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

  /*Validacion personalizada de EDITAR CONTRASEÑA*/
  $.validator.setDefaults({
    submitHandler: function () {
      funcion = "cambiarContra";
      let pass_old = $("#pass_old").val();
      let pass_new = $("#pass_new").val();
      $.post(
        "../Controllers/UserController.php",
        { funcion, pass_old, pass_new },
        (response) => {
          console.log(response);
          if (response == "success") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Se ah cambiado su contraseña correctamente",
              showConfirmButton: false,
              timer: 2000,
            }).then(function () {
              /*Para vacias todos los inputs */
              $("#form-contra").trigger("reset");
              llenarHistorial();
            });
          } else if (response == "error") {
            Swal.fire({
              icon: "warning",
              title: "Contraseña incorrecta",
              text: "Ingrese su contraseña actual para poder cambiarla",
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Hubo conflicto al cambiar su contraseña,comuníquese con el area de sistemas",
            });
          }
        }
      );
    },
  });

  /*Validacion personalizada de EDITAR CONTRASEÑA*/
  jQuery.validator.addMethod(
    "letras",
    function (value, element) {
      let variable = value.replace(/ /g, "");
      return /^[ A-Za-z]+$/.test(variable);
    },

    "*Este campo solo permite letras."
  );
  /*Validacion del modal  EDITAR CONTRASEÑA*/
  $("#form-contra").validate({
    rules: {
      pass_old: {
        required: true,
        minlength: 8,
        maxlength: 15,
      },
      pass_new: {
        required: true,
        minlength: 8,
        maxlength: 15,
      },
      pass_repeat: {
        required: true,
        equalTo: "#pass_new",
      },
    },
    messages: {
      pass_old: {
        required: "*Este campo es obligatorio",
        minlength: "*La contraseña debe ser de minimo 8 caracteres",
        maxlength: "*La contraseña debe ser de máximo 15 caracteres",
      },
      pass_new: {
        required: "*Este campo es obligatorio",
        minlength: "*La contraseña debe ser de minimo 8 caracteres",
        maxlength: "*La contraseña debe ser de máximo 15 caracteres",
      },
      pass_repeat: {
        required: "*Este campo es obligatorio",
        equalTo: "*La contraseña no coincide con el anterior ingresado",
      },
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
