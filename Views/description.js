$(document).ready(function () {
  //Esta pagina va ser accedida por todos los usuarios
  verificarSesion();
  verificarProducto();
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
  function verificarSesion() {
    funcion = "verificarSesion";
    $.post("../Controllers/UserController.php", { funcion }, (response) => {
      console.log(response);
      if (response != "") {
        let sesion = JSON.parse(response);
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
        //Ocultams la campana de notificaciones cuando no hay sesion
        $("#notificacion").hide();
        $("#nav_notificaciones").hide();
      }
    });
  }
  //Funcion asincrona para verificar los productos
  async function verificarProducto() {
    funcion = "verificarProducto";
    //Otra forma de enviar datos POST
    let data = await fetch("../Controllers/ProductStoreController.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "funcion=" + funcion,
    });
    if (data.ok) {
      let response = await data.text();
      try {
        let producto = JSON.parse(response);
        let template = "";
        console.log(response);
        //Que se ejecute cuando haya un usuario en sesion
        if (producto.usuario_sesion != "") {
          readNotificaciones();
        }
        //Verificar si hay imagenes del producto
        if (producto.imagenes.length > 0) {
          template += `
          <div class="col-12">
            <img id="imagen_principal" src="../Util/Img/Products/${producto.imagenes[0].nombre}" class="img-fluid">
          </div>
          <div class="col-12 product-image-thumbs">

          `;
          producto.imagenes.forEach((imagen) => {
            template += `
            <button prod_img="${imagen.nombre} " class="imagen_pasarelas product-image-thumb">
              <img src="../Util/Img/Products/${imagen.nombre}">
            </button>
            `;
          });
          template += `
          </div>
          `;
        } else {
          template += `
          <div class="col-12">
            <img id="imagen_principal" src="../Util/Img/Products/${producto.imagen}" class="product-image img-fluid">
          </div>

          `;
        }
        $("#imagenes").html(template);
        $("#producto").text(producto.producto);
        $("#marca").text("Marca: " + producto.marca);
        $("#sku").text("SKU: " + producto.sku);
        let template1 = "";
        if (producto.calificacion != 0) {
          template += "<br>";
          for (let index = 0; index < producto.calificacion; index++) {
            template1 += ` <i class="fas fa-star text-warning"></i>`;
          }
          let estrellas_faltantes = 5 - producto.calificacion;
          for (let index = 0; index < estrellas_faltantes; index++) {
            template1 += ` <i class="far fa-star text-warning"></i>`;
          }
        }
        if (producto.descuento != 0) {
          template1 += `<br>
          <span class="text-muted" style="text-decoration:line-through">S/ ${producto.precio}</span>
          <span class="text-muted">- ${producto.descuento}%</span><br>`;
        }
        template1 += `
        <h4 class="text-danger">S/ ${producto.precio_descuento}</h4>`;
        $("#informacion_precios").html(template1);
        let template2 = "";
        if (producto.envio == "Gratis") {
          template2 += `<i class="fas fa-truck-moving text-danger"></i> 
          <span class="ml-1"> Envio: </span>
          <span class="badge bg-success">Envio gratis </span>`;
        } else {
          template2 += `<i class="fas fa-truck-moving text-danger"></i> 
          <span class="ml-1"> Envio: </span>
          <span class="mr-1">S/ 15,00</span>`;
        }
        template2 += `<br>`;
        template2 += `<i class="fas fa-store text-danger"></i>
        <span class="ml-1">Recogelo en la tienda: ${producto.direccion_tienda}</span>`;
        $("#informacion_envio").html(template2);
        $("#nombre_tienda").text(producto.tienda);
        $("#numero_resenas").text(producto.numero_resenas + " " + "reseñas");
        $("#promedio_calificacion_tienda").text(
          producto.promedio_calificacion_tienda
        );
        $("#product-desc").text(producto.detalles);
        let template3 = "";
        let cont = 0;
        producto.caracteristicas.forEach((caracteristica) => {
          cont++;
          template3 += `
          <tr>
            <td>${cont}</td>
            <td>${caracteristica.titulo}</td>
            <td>${caracteristica.descripcion}</td>
          </tr>
          `;
        });
        $("#caracteristicas").html(template3);
        let template4 = "";
        producto.resenas.forEach((resena) => {
          template4 += `
                <div class="card-comment">
                  <!-- User image -->
                  <img class="img-circle img-sm" src="../Util/Img/Users/${resena.avatar}" alt="User Image">

                    <div class="comment-text">
                      <span class="username">
                        ${resena.usuario}`;
          for (let index = 0; index < resena.calificacion; index++) {
            template4 += ` <i class="fas fa-star text-warning"></i>`;
          }
          let estrellas_faltantes = 5 - resena.calificacion;
          for (let index = 0; index < estrellas_faltantes; index++) {
            template4 += ` <i class="far fa-star text-warning"></i>`;
          }
          template4 += `<span class="text-muted float-right">${resena.fecha_creacion}</span>
                      </span><!-- /.username -->
                      ${resena.descripcion}
                    </div>
                  <!-- /.comment-text -->
                </div>
      `;
        });

        $("#resenas").html(template4);
        let template5 = "";
        //Mostrar input para escribir pregunta cuando este en sesion abierta menos el dueño.
        if (producto.bandera == 2) {
          template5 += `<div class="card-footer">
                          <form id="form_pregunta">
                              <div class="input-group">
                                  <img class="direct-chat-img mr-2" src="../Util/Img/Users/${producto.avatar_sesion}"
                                      alt="Message User Image">
                                  <input type="text" id="pregunta" name="message" placeholder="Escribir pregunta"
                                      class="form-control" required>
                                  <span class="input-group-append">
                                      <button type="submit" class="btn btn-primary">Enviar</button>
                                  </span>
                              </div>
                          </form>
                      </div>`;
        }
        template5 += `<div class="direct-chat-messages direct-chat-danger preguntas">`;
        //Mostrar las preguntas en cuando este en sesion y no este tmbn
        producto.preguntas.forEach((pregunta) => {
          template5 += `<div class="direct-chat-msg">
                          <div class="direct-chat-infos clearfix">
                              <span class="direct-chat-name float-left">${pregunta.username}</span>
                              <span class="direct-chat-timestamp float-right">${pregunta.fecha_creacion}</span>
                          </div>
                          <!-- /.direct-chat-infos -->
                          <img class="direct-chat-img" src="../Util/Img/Users/${pregunta.avatar}"
                              alt="Message User Image">
                          <!-- /.direct-chat-img -->
                          <div class="direct-chat-text">
                          ${pregunta.contenido}
                          </div>
                      `;
          //Verificar si la pregunta tiene respuesta o no (0->no tiene && 1->si tiene)
          if (pregunta.estado_respuesta == "0") {
            //Verificar si el dueño esta en sesion para poder mostrar
            if (producto.bandera == 1) {
              //Mostrar cuando la pregunta no tiene respuesta
              template5 += `<div class="card-footer">
                            <form>
                                <div class="input-group">
                                    <img class="direct-chat-img mr-2" src="../Util/Img/Users/${producto.avatar}"
                                        alt="Message User Image">
                                    <input type="text" placeholder="Responder pregunta"
                                        class="form-control respuesta" required>
                                        <input type='hidden' value='${pregunta.id}' class='id_pregunta'>
                                    <span class="input-group-append">
                                        <button class="btn btn-danger enviar_respuesta">Enviar</button>
                                    </span>
                                </div>
                            </form>
                        </div>`;
            }
          } else {
            //Mostrar cuando la pregunta tiene respuesta
            template5 += `<div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">${producto.username}</span>
                                <span class="direct-chat-timestamp float-left">${pregunta.respuesta.fecha_creacion}</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="../Util/Img/Users/${producto.avatar}"
                                alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                            ${pregunta.respuesta.contenido}
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>`;
          }

          template5 += `</div>`;
        });
        template5 += `</div>`;
        $("#product-pre").html(template5);
      } catch (error) {
        console.error(error);
        //Redireccionamos cuando sale error o cuando intentan cambiar el id q pasamos x GET
        console.log(response);
        if (response == "error") {
          location.href = "../index.php";
        }
      }
    } else {
      Swal.fire({
        icon: "error",
        title: data.statusText,
        text: "Hubo conflicto de codigo: " + data.status,
      });
    }
  }
  //Para q cada vez haga clic en los botones
  //Ver la interaccion en la pasarelas de imagenes
  $(document).on("click", ".imagen_pasarelas", (e) => {
    //Capturamos el primer elemento con this y que este activo
    let elemento = $(this)[0].activeElement;
    //El attr es para capturar un atributo o cambiar
    let img = $(elemento).attr("prod_img");
    $("#imagen_principal").attr("src", "../Util/Img/Products/" + img);
  });
  /************************************************************************************************************************/
  //FUNCION PARA INSERTAR LAS PREGUNTAS
  async function realizarPregunta(pregunta) {
    funcion = "realizarPregunta";
    //Otra forma de enviar datos POST
    let data = await fetch("../Controllers/PreguntaController.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "funcion=" + funcion + "&&pregunta=" + pregunta,
    });
    if (data.ok) {
      let response = await data.text();
      try {
        let respuesta = JSON.parse(response);
        console.log(respuesta);
        //Para que los resultados aparescan al instante
        verificarProducto();
        //Para limpiar los campos
        $("#form_pregunta").trigger(reset);
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
  //Metodo submit para poder traer las preguntas e insertar en la tabla
  $(document).on("submit", "#form_pregunta", (e) => {
    let pregunta = $("#pregunta").val();
    realizarPregunta(pregunta);
    e.preventDefault();
  });
  /************************************************************************************************************************/
  //FUNCION PARA INSERTAR LAS RESPUESTAS
  async function realizarRespuesta(respuesta, id_pregunta) {
    funcion = "realizarRespuesta";
    //Otra forma de enviar datos POST
    let data = await fetch("../Controllers/RespuestaController.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body:
        "funcion=" +
        funcion +
        "&&respuesta=" +
        respuesta +
        "&&id_pregunta=" +
        id_pregunta,
    });
    if (data.ok) {
      let response = await data.text();
      try {
        let respuesta = JSON.parse(response);
        console.log(respuesta);
        //Para que los resultados aparescan al instante
        verificarProducto();
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
  //Metodo click para poder traer las repsuesta e insertar en la tabla
  $(document).on("click", ".enviar_respuesta", (e) => {
    //Capturar todos los elementos de respuesta
    let elemento = $(this)[0].activeElement.parentElement.parentElement;
    //Navegar en cada elemento y capturarlos
    let respuesta = $(elemento).children("input.respuesta").val();
    let id_pregunta = $(elemento).children("input.id_pregunta").val();
    if (respuesta != "") {
      realizarRespuesta(respuesta, id_pregunta);
    } else {
      //Error
      toastr.error("* La respuesta esta vacia");
    }
    e.preventDefault();
  });
});
