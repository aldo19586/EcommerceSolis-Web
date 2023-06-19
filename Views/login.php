<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | FerreteriaSolis</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../Util/Css/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../Util/Css/adminlte.min.css">
    <!-- Alerts style-->
    <link rel="stylesheet" href="../Util/Css/toastr.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box mt-10">
        <div class="login-logo">
            <img src="../Util/Img/dazomi.png" class="profile-user-log img-fluid " width="200px" height="200px">
            <br><a href="../index.php"><b>Dazomi</b>Store</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"></p>

                <form id="form-login">
                    <div class="input-group mb-3">
                        <input id="user" type="text" class="form-control" placeholder="Usuario" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa-solid fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="pass" type="password" class="form-control" placeholder="Contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="social-auth-links text-center mb-3">
                        <button type="submit" href="#" class="btn btn-block btn-primary"> Iniciar Sesion
                        </button>
                    </div>

                </form>


                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html"> He olvidado mi contraseña</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Registrarse</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../Util/Js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../Util/Js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../Util/Js/adminlte.min.js"></script>
    <!-- Login.js -->
    <script src="login.js"></script>
    <!-- Alerts.js -->
    <script src="../Util/Js/toastr.min.js"></script>

</body>

</html>