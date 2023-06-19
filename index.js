$(document).ready(function () {
  var funcion;
  /*Verificar la Sesion - Reemplazar - Ocultar -etc*/
  verificarSesion();
  llenarProductos();
  //FUNCION PARA LEER LAS NOTIFICACIONES
  async function readNotificaciones() {
    funcion = "readNotificaciones";
    //Otra forma de enviar datos POST
    let data = await fetch("Controllers/NotificacionController.php", {
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
                          <a href="${notificacion.url_1}&&noti=${notificacion.id}" class="dropdown-item">
                          <div class="media">
                              <img src="Util/Img/Products/${notificacion.imagen}" alt="User Avatar"
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
    $.post("Controllers/UserController.php", { funcion }, (response) => {
      console.log(response);
      if (response != "") {
        let sesion = JSON.parse(response);
        $("#nav_login").hide();
        $("#nav_register").hide();
        $("#usuario_nav").text(sesion.user + " #" + sesion.id);
        $("#avatar_nav").attr("src", "Util/Img/Users/" + sesion.avatar);
        $("#avatar_menu").attr("src", "Util/Img/Users/" + sesion.avatar);
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
  //Funcion asincrona para llenar productos
  async function llenarProductos() {
    funcion = "llenarProductos";
    //Otra forma de enviar datos POST
    let data = await fetch("Controllers/ProductStoreController.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "funcion=" + funcion,
    });
    if (data.ok) {
      let response = await data.text();
      try {
        let productos = JSON.parse(response);
        //console.log(productos);
        let template = "";
        productos.forEach((producto) => {
          template += `
          <div class="col-sm-2">
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-sm-12">
                                      <img src="Util/Img/Products/${producto.imagen}" class="img-fluid">
                                  </div>
                                  <div class="col-sm-12">
                                      <span class="textx-muted float-left">Marca: ${producto.marca}</span><br>
                                      <a href="Views/description.php?name=${producto.producto}&&id=${producto.id}" class="titulo_producto">${producto.producto}</a>`;
          if (producto.envio == "Gratis") {
            template += `<span class="badge bg-success">Envio gratis </span>`;
          }
          if (producto.calificacion != 0) {
            template += "<br>";
            for (let index = 0; index < producto.calificacion; index++) {
              template += ` <i class="fas fa-star text-warning"></i>`;
            }
            let estrellas_faltantes = 5 - producto.calificacion;
            for (let index = 0; index < estrellas_faltantes; index++) {
              template += ` <i class="far fa-star text-warning"></i>`;
            }
          }
          if (producto.descuento != 0) {
            template += `<br>
            <span class="text-muted" style="text-decoration:line-through">S/ ${producto.precio}</span>
            <span class="text-muted">- ${producto.descuento}%</span><br>`;
          }

          template += `

                                      <h4 class="text-danger">S/ ${producto.precio_descuento}</h4>

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
          `;
        });
        $("#productos").html(template);
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
});
