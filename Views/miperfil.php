<?php
include_once 'Layouts/General/header.php'
 ?>
<!-- Modal Editar password -->
<div class="modal fade" id="modal_contra" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDITAR CONTRASEÑA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-contra">
                    <div class="form-group">
                        <label for="pass_old">Ingrese contraseña actual: </label>
                        <input type="password" name="pass_old" class="form-control form-control-sm" id="pass_old"
                            placeholder="Ingrese contraseña actual">
                    </div>
                    <div class="form-group">
                        <label for="pass_new">Ingrese nueva contraseña: </label>
                        <input type="password" name="pass_new" class="form-control form-control-sm" id="pass_new"
                            placeholder="Ingrese mueva contraseña">
                    </div>
                    <div class="form-group">
                        <label for="pass_repeat">Repita nueva contraseña: </label>
                        <input type="password" name="pass_repeat" class="form-control form-control-sm" id="pass_repeat"
                            placeholder="Repita la nueva contraseña">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<!-- Modal agregar direcciones -->
<div class="modal fade" id="modal_direcciones" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">AGREGAR DIRECCION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-direccion">
                    <div class="form-group">
                        <label for="">Departamento: </label>
                        <select id="departamento" class="form-control" style="width:100%" required></select>
                    </div>
                    <div class="form-group">
                        <label for="">Provincia: </label>
                        <select id="provincia" class="form-control" style="width:100%" required></select>
                    </div>
                    <div class="form-group">
                        <label for="">Distrito: </label>
                        <select id="distrito" class="form-control" style="width:100%" required></select>
                    </div>
                    <div class="form-group">
                        <label for="">Direccion: </label>
                        <input id="direccion" class="form-control" placeholder="Ingrese su direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="">Referencia: </label>
                        <input id="referencia" class="form-control" placeholder="Ingrese alguna referencia">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- Modal Editar datos personales -->
<div class="modal fade" id="modal_datos" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDITAR DATOS PERSONALES</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-datos" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombres_mod">Nombres: </label>
                        <input type="text" name="nombres_mod" class="form-control form-control-sm" id="nombres_mod"
                            placeholder="Ingrese nombres">
                    </div>
                    <div class="form-group">
                        <label for="apellidos_mod">Apellidos: </label>
                        <input type="text" name="apellidos_mod" class="form-control form-control-sm" id="apellidos_mod"
                            placeholder="Ingrese apellidos">
                    </div>
                    <div class="form-group">
                        <label for="dni_mod">Dni: </label>
                        <input type="text" name="dni_mod" class="form-control form-control-sm" id="dni_mod"
                            placeholder="Ingrese dni">
                    </div>
                    <div class="form-group">
                        <label for="email_mod">Email: </label>
                        <input type="text" name="email_mod" class="form-control form-control-sm" id="email_mod"
                            placeholder="Ingrese email">
                    </div>
                    <div class="form-group">
                        <label for="telefono_mod">Telefono: </label>
                        <input type="text" name="telefono_mod" class="form-control form-control-sm" id="telefono_mod"
                            placeholder="Ingrese telefono">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Avatar</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar_mod" name="avatar_mod">
                                <label class="custom-file-label" for="exampleInputFile">Seleccione un avatar</label>
                            </div>

                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<title>My profile | FerreteriaSolis </title>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->

                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-info">
                        <h3 id="username" class="widget-user-username">#</h3>
                        <h5 id="tipo_usuario" class="widget-user-desc">#</h5>
                    </div>
                    <div class="widget-user-image">
                        <img id="avatar_perfil" class="img-circle elevation-2" src="../Util/Img/default.jpg"
                            alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">SALES</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text">FOLLOWERS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">PRODUCTS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->


                <!-- About Me Box -->

                <div class="card card-light ">
                    <div class="card-header  border-bottom-0">
                        <strong>Mis datos personales</strong>
                        <div class="card-tools">
                            <button type="button" class="editar_datos btn btn-tool" data-bs-toggle="modal"
                                data-bs-target="#modal_datos">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0 mt-3">
                        <div class="row">
                            <div class="col-8">
                                <h2 id="nombres" class="lead"><b>Nicole Pearson</b></h2>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-address-card"></i></span>
                                        Dni #: <span id="dni"></span> </li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-at"></i></span>
                                        Email #: <span id="email"></span> </li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                        Telefono #: <span id="telefono"></span></li>
                                </ul>
                            </div>
                            <div class="col-4 text-center">
                                <img src="../Util/Img/datospersonales.png" alt="user-avatar"
                                    class="img-circle img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-warning btn-block" data-bs-toggle="modal"
                            data-bs-target="#modal_contra">Editar contraseña</button>

                    </div>

                </div>
                <div class="card card-light ">
                    <div class="card-header  border-bottom-0">
                        <strong>Mis direcciones de envio</strong>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal"
                                data-bs-target="#modal_direcciones">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div id="direcciones" class="card-body pt-0 mt-3">


                    </div>
                    <div class="card card-light ">
                        <div class="card-header  border-bottom-0">
                            <strong>Mi targetas de pago</strong>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-0 mt-3">
                            <div class="row">
                                <div class="col-8">
                                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist /
                                        Coffee Lover </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i
                                                    class="fas fa-lg fa-building"></i></span>
                                            Address: Demo Street 123,
                                            Demo City 04312, NJ</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                            Phone #: + 800 - 12 12 23 52</li>
                                    </ul>
                                </div>
                                <div class="col-4 text-center">
                                    <img src="../Util/Img/pago.png" alt="user-avatar" class=" img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- /.card -->
                </div>
            </div>

            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link " href="#activity" data-toggle="tab">Activity</a>
                            </li>
                            <li class="nav-item"><a class="nav-link active" href="#timeline"
                                    data-toggle="tab">Historial</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class=" tab-pane" id="activity">
                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg"
                                            alt="user image">
                                        <span class="username">
                                            <a href="#">Jonathan Burke Jr.</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">Shared publicly - 7:30 PM today</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore the hate as they create awesome
                                        tools to help create filler text for everyone from bacon lovers
                                        to Charlie Sheen fans.
                                    </p>

                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>
                                            Share</a>
                                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                                            Like</a>
                                        <span class="float-right">
                                            <a href="#" class="link-black text-sm">
                                                <i class="far fa-comments mr-1"></i> Comments (5)
                                            </a>
                                        </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text"
                                        placeholder="Type a comment">
                                </div>
                                <!-- /.post -->

                                <!-- Post -->
                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg"
                                            alt="User Image">
                                        <span class="username">
                                            <a href="#">Sarah Ross</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">Sent you a message - 3 days ago</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore the hate as they create awesome
                                        tools to help create filler text for everyone from bacon lovers
                                        to Charlie Sheen fans.
                                    </p>

                                    <form class="form-horizontal">
                                        <div class="input-group input-group-sm mb-0">
                                            <input class="form-control form-control-sm" placeholder="Response">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-danger">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.post -->

                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg"
                                            alt="User Image">
                                        <span class="username">
                                            <a href="#">Adam Jones</a>
                                            <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">Posted 5 photos - 5 days ago</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <img class="img-fluid mb-3" src="../../dist/img/photo2.png"
                                                        alt="Photo">
                                                    <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-6">
                                                    <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg"
                                                        alt="Photo">
                                                    <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>
                                            Share</a>
                                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                                            Like</a>
                                        <span class="float-right">
                                            <a href="#" class="link-black text-sm">
                                                <i class="far fa-comments mr-1"></i> Comments (5)
                                            </a>
                                        </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text"
                                        placeholder="Type a comment">
                                </div>
                                <!-- /.post -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="timeline">
                                <!-- The timeline -->
                                <div id="historiales" class="timeline timeline-inverse">
                                    <!-- timeline time label -->

                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputName" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="inputExperience"
                                                placeholder="Experience"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputSkills"
                                                placeholder="Skills">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> I agree to the <a href="#">terms and
                                                        conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?php
include_once 'Layouts/General/footer.php'
 ?>
<script src="miperfil.js"></script>