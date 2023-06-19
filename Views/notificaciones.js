$(document).ready(function () {
  //Esta pagina va ser accedida por todos los usuarios
  verificarSesion();
  //Para q se pinte el nav notifiaciones
  $("#active_nav_notificaciones").addClass("active");
  toastr.options = {
    debug: false,
    positionClass: "toast-bottom-full-width",
    onclick: null,
    fadeIn: 300,
    fadeOut: 1000,
    timeOut: 5000,
    extendedTimeOut: 1000,
  };
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
        readAllNotificaciones();
        //Mostramos la campana de notificaciones cuando hay sesion
        $("#notificacion").show();
        $("#nav_notificaciones").show();
      } else {
        $("#nav_usuario").hide();
        //Ocultams la campana de notificaciones cuando no hay sesion
        $("#notificacion").hide();
        $("#nav_notificaciones").hide();
        //Validar x si el ususario no esta en sesion no puede ir al url de notificaciones
        location.href = "login.php";
      }
    });
  }
  //Funcion para traer las notificaciones
  async function readAllNotificaciones() {
    funcion = "readAllNotificaciones";
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
        let template = "";
        let notification = [];
        notificaciones.forEach((notificacion) => {
          template = "";
          template += `
                            <div class="row">
                              <div class="col-sm-1 text-center">
                              <button id="" type="button" class="btn eliminar_noti" attrid="${notificacion.id}" style="margin-top:25px">
                                <i   style="font-size: 30px" class="far fa-trash-alt text-danger"></i>
                              </button>
                              </div>
                              <div class="col-sm-11">
                              <a href="../${notificacion.url_1}&&noti=${notificacion.id}" class="dropdown-item">
                              <div class="media">
                                  <img src="../Util/Img/Products/${notificacion.imagen}" alt="User Avatar"
                                      class="img-size-50 img-circle mr-3">
                                  <div class="media-body">
                                      <h3 class="dropdown-item-title">
                                          ${notificacion.titulo}
                                      `;
          if (notificacion.estado_abierto == 0) {
            template += "<span class='badge badge-success'>Cerrado</span>";
          } else {
            template += "<span class='badge badge-danger'>Abierto</span>";
          }

          template += `</h3>
                            <p class="text-sm">${notificacion.asunto}
                                      <p class="text-sm text-muted">${notificacion.contenido}</p>
                                      <span class="float-right text-muted text-sm">${notificacion.fecha_creacion}</span>
                                  </div>
                              </div>
                          </a>
                              </div>
                            </div>
                            `;
          notification.push({ celda: template });
        });
        console.log(notification);
        $("#noti").DataTable({
          data: notification,
          //Para q no ordene automaticamente el datatble
          aaSorting: [],
          searching: true,
          //Para q muestre un scroll
          scrollX: true,
          autoWidth: false,
          columns: [{ data: "celda" }],
          destroy: true,
          language: espanol,
        });
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
  //Funcion para eliminar las notificaciones
  async function eliminarNotificacion($id_notificacion) {
    funcion = "eliminarNotificacion";
    //Otra forma de enviar datos POST
    let data = await fetch("../Controllers/NotificacionController.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "funcion=" + funcion + "&&id_notificacion=" + $id_notificacion,
    });
    if (data.ok) {
      let response = await data.text();
      try {
        let respuesta = JSON.parse(response);
        console.log(respuesta);
        if (respuesta.mensaje1 == "Notificacion eliminada") {
          toastr.success("* El item se elimino de sus notificaciones");
        } else if (respuesta.mensaje1 == "Error al eliminar") {
          toastr.error("* No intente vulnerar el sistema");
        } else {
          toastr.error("* Comuníquese con el área de Sistemas");
        }
        readAllNotificaciones();
        readNotificaciones();
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
  //Creamos un evento click para eliminar las notificaciones
  $(document).on("click", ".eliminar_noti", (e) => {
    let elemento = $(this)[0].activeElement;
    let id = $(elemento).attr("attrid");
    eliminarNotificacion(id);
  });
});
//Para que el datatable este en español
let espanol = {
  processing: "Procesando.)..",
  lengthMenu: "Mostrar _MENU_ registros",
  zeroRecords: "No se encontraron resultados",
  emptyTable: "Ningún dato disponible en esta tabla",
  infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
  infoFiltered: "(filtrado de un total de _MAX_ registros)",
  search: "Buscar:",
  infoThousands: ",",
  loadingRecords: "Cargando...",
  paginate: {
    first: "Primero",
    last: "Último",
    next: "Siguiente",
    previous: "Anterior",
  },
  aria: {
    sortAscending: ": Activar para ordenar la columna de manera ascendente",
    sortDescending: ": Activar para ordenar la columna de manera descendente",
  },
  buttons: {
    copy: "Copiar",
    colvis: "Visibilidad",
    collection: "Colección",
    colvisRestore: "Restaurar visibilidad",
    copyKeys:
      "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
    copySuccess: {
      1: "Copiada 1 fila al portapapeles",
      _: "Copiadas %ds fila al portapapeles",
    },
    copyTitle: "Copiar al portapapeles",
    csv: "CSV",
    excel: "Excel",
    pageLength: {
      "-1": "Mostrar todas las filas",
      _: "Mostrar %d filas",
    },
    pdf: "PDF",
    print: "Imprimir",
    renameState: "Cambiar nombre",
    updateState: "Actualizar",
    createState: "Crear Estado",
    removeAllStates: "Remover Estados",
    removeState: "Remover",
    savedStates: "Estados Guardados",
    stateRestore: "Estado %d",
  },
  autoFill: {
    cancel: "Cancelar",
    fill: "Rellene todas las celdas con <i>%d</i>",
    fillHorizontal: "Rellenar celdas horizontalmente",
    fillVertical: "Rellenar celdas verticalmentemente",
  },
  decimal: ",",
  searchBuilder: {
    add: "Añadir condición",
    button: {
      0: "Constructor de búsqueda",
      _: "Constructor de búsqueda (%d)",
    },
    clearAll: "Borrar todo",
    condition: "Condición",
    conditions: {
      date: {
        after: "Despues",
        before: "Antes",
        between: "Entre",
        empty: "Vacío",
        equals: "Igual a",
        notBetween: "No entre",
        notEmpty: "No Vacio",
        not: "Diferente de",
      },
      number: {
        between: "Entre",
        empty: "Vacio",
        equals: "Igual a",
        gt: "Mayor a",
        gte: "Mayor o igual a",
        lt: "Menor que",
        lte: "Menor o igual que",
        notBetween: "No entre",
        notEmpty: "No vacío",
        not: "Diferente de",
      },
      string: {
        contains: "Contiene",
        empty: "Vacío",
        endsWith: "Termina en",
        equals: "Igual a",
        notEmpty: "No Vacio",
        startsWith: "Empieza con",
        not: "Diferente de",
        notContains: "No Contiene",
        notStarts: "No empieza con",
        notEnds: "No termina con",
      },
      array: {
        not: "Diferente de",
        equals: "Igual",
        empty: "Vacío",
        contains: "Contiene",
        notEmpty: "No Vacío",
        without: "Sin",
      },
    },
    data: "Data",
    deleteTitle: "Eliminar regla de filtrado",
    leftTitle: "Criterios anulados",
    logicAnd: "Y",
    logicOr: "O",
    rightTitle: "Criterios de sangría",
    title: {
      0: "Constructor de búsqueda",
      _: "Constructor de búsqueda (%d)",
    },
    value: "Valor",
  },
  searchPanes: {
    clearMessage: "Borrar todo",
    collapse: {
      0: "Paneles de búsqueda",
      _: "Paneles de búsqueda (%d)",
    },
    count: "{total}",
    countFiltered: "{shown} ({total})",
    emptyPanes: "Sin paneles de búsqueda",
    loadMessage: "Cargando paneles de búsqueda",
    title: "Filtros Activos - %d",
    showMessage: "Mostrar Todo",
    collapseMessage: "Colapsar Todo",
  },
  select: {
    cells: {
      1: "1 celda seleccionada",
      _: "%d celdas seleccionadas",
    },
    columns: {
      1: "1 columna seleccionada",
      _: "%d columnas seleccionadas",
    },
    rows: {
      1: "1 fila seleccionada",
      _: "%d filas seleccionadas",
    },
  },
  thousands: ".",
  datetime: {
    previous: "Anterior",
    next: "Proximo",
    hours: "Horas",
    minutes: "Minutos",
    seconds: "Segundos",
    unknown: "-",
    amPm: ["AM", "PM"],
    months: {
      0: "Enero",
      1: "Febrero",
      10: "Noviembre",
      11: "Diciembre",
      2: "Marzo",
      3: "Abril",
      4: "Mayo",
      5: "Junio",
      6: "Julio",
      7: "Agosto",
      8: "Septiembre",
      9: "Octubre",
    },
    weekdays: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
  },
  editor: {
    close: "Cerrar",
    create: {
      button: "Nuevo",
      title: "Crear Nuevo Registro",
      submit: "Crear",
    },
    edit: {
      button: "Editar",
      title: "Editar Registro",
      submit: "Actualizar",
    },
    remove: {
      button: "Eliminar",
      title: "Eliminar Registro",
      submit: "Eliminar",
      confirm: {
        _: "¿Está seguro que desea eliminar %d filas?",
        1: "¿Está seguro que desea eliminar 1 fila?",
      },
    },
    error: {
      system:
        'Ha ocurrido un error en el sistema (<a target="\\" rel="\\ nofollow" href="\\">Más información&lt;\\/a&gt;).</a>',
    },
    multi: {
      title: "Múltiples Valores",
      info: "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
      restore: "Deshacer Cambios",
      noMulti:
        "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
    },
  },
  info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
  stateRestore: {
    creationModal: {
      button: "Crear",
      name: "Nombre:",
      order: "Clasificación",
      paging: "Paginación",
      search: "Busqueda",
      select: "Seleccionar",
      columns: {
        search: "Búsqueda de Columna",
        visible: "Visibilidad de Columna",
      },
      title: "Crear Nuevo Estado",
      toggleLabel: "Incluir:",
    },
    emptyError: "El nombre no puede estar vacio",
    removeConfirm: "¿Seguro que quiere eliminar este %s?",
    removeError: "Error al eliminar el registro",
    removeJoiner: "y",
    removeSubmit: "Eliminar",
    renameButton: "Cambiar Nombre",
    renameLabel: "Nuevo nombre para %s",
    duplicateError: "Ya existe un Estado con este nombre.",
    emptyStates: "No hay Estados guardados",
    removeTitle: "Remover Estado",
    renameTitle: "Cambiar Nombre Estado",
  },
};
