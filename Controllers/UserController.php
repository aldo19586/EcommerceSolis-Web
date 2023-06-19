<?php
include_once '../Models/User.php';
include_once '../Models/Historial.php';
//Llamamos a este archivo para poder encryptar la contraseña y el id
include_once '../Util/Config/config.php';
$usuario = new Usuario();
$historial= new Historial();
session_start();
/*Iniciar la Sesion - RECIBIR DE VIEWS & ENVIAR DATOS A MODELS */
if($_POST['funcion']=='login'){
    /*Recibe*/
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $usuario -> verificarUsuario($user);
    if($usuario->objetos!=null){
        //Para desencriptar 
        $pass_bd=openssl_decrypt($usuario->objetos[0]->password,CODE,KEY);
        if($pass_bd==$pass){
            //No se usa el foreach xq es uno solo q dato q queremos
                /*Envia las variables sesiones de datos a views*/
                $_SESSION['id']=$usuario->objetos[0]->id;
                $_SESSION['user']=$usuario->objetos[0]->user;
                $_SESSION['tipoUsuario']=$usuario->objetos[0]->id_tipo;
                $_SESSION['avatar']=$usuario->objetos[0]->avatar;
                echo 'logueado';
            
        }
        

    }

}
 /*Verificar la Sesion - ENVIAR DATOS A VIEWS Q TRAE DE MODELS*/
if($_POST['funcion']=='verificarSesion'){
    if(!empty($_SESSION['id'])){
        $json[]=array(
            'id'=>$_SESSION['id'],
            'user'=>$_SESSION['user'],
            'tipoUsuario'=>$_SESSION['tipoUsuario'],
            'avatar'=>$_SESSION['avatar']
        );
        //para codificar y el [0]< es para q traiga un valor.
        $jsonString = json_encode($json[0]);
        echo $jsonString;
    }else{
        echo '';
    }

}

 /*Verificar el Usuario - RECIBIR DATOS DE VIEWS*/
 if($_POST['funcion']=='verificarUsuario'){
    $username = $_POST['value'];
    $usuario -> verificarUsuario($username);
    if($usuario->objetos!=null){
        echo 'success';

    }
}

 /*Registrar el Usuario - RECIBIR DATOS DE VIEWS*/
 if($_POST['funcion']=='registrarUsuario'){
    $username = $_POST['username'];
    //Para encryptar la contraseña
    $pass=openssl_encrypt($_POST['pass'],CODE,KEY) ;
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $dni=$_POST['dni'];
    $email=$_POST['email'];
    $telefono=$_POST['telefono'];
    $usuario -> registrarUsuario($username,$pass,$nombres,$apellidos,$dni,$email,$telefono);
    echo 'success';
}
/*Obtener datos del Usuario - ENVIAR DATOS A VIEWS*/
if($_POST['funcion']=='obtenerDatos'){
   $usuario->obtenerDatos($_SESSION['id']);
   foreach ($usuario ->objetos as $objeto ) {
    $json[]=array(
        'username'=>$objeto->user,
        'nombres'=>$objeto->nombres,
        'apellidos'=>$objeto->apellidos,
        'dni'=>$objeto->dni,
        'email'=>$objeto->email,
        'telefono'=>$objeto->telefono,
        'avatar'=>$objeto->avatar,
        'tipo_usuario'=>$objeto->tipo
    );
   }
   /*Para Codificar el array */
   $jsonString = json_encode($json[0]);
   echo $jsonString;
}
/*Editar datos del Usuario - RECIBIR DATOS DE VIEWS*/
if($_POST['funcion']=='editar_datos'){
    $id_usuario=$_SESSION['id'];
    $nombres=$_POST['nombres_mod'];
    $apellidos=$_POST['apellidos_mod'];
    $dni=$_POST['dni_mod'];
    $email=$_POST['email_mod'];
    $telefono=$_POST['telefono_mod'];
    $avatar=$_FILES['avatar_mod']['name'];
    $usuario ->obtenerDatos($id_usuario);
    $datos_cambiados='hizo los siguientes cambios: ';
    if($nombres!=$usuario->objetos[0]->nombres || $apellidos!=$usuario->objetos[0]->apellidos || $dni!=$usuario->objetos[0]->dni ||$email!=$usuario->objetos[0]->email ||$telefono!=$usuario->objetos[0]->telefono || $avatar!=''){
        if($nombres!=$usuario->objetos[0]->nombres){
            $datos_cambiados.="Su nombre cambió de ".$usuario->objetos[0]->nombres.' a '.$nombres.'. ';
        }
        if($apellidos!=$usuario->objetos[0]->apellidos){
            $datos_cambiados.="Su apellido cambió de ".$usuario->objetos[0]->apellidos.' a '.$apellidos.'. ';
        }
        if($dni!=$usuario->objetos[0]->dni){
            $datos_cambiados.="Su dni cambió de ".$usuario->objetos[0]->dni.' a '.$dni.'. ';
        }
        if($email!=$usuario->objetos[0]->email){
            $datos_cambiados.="Su email cambió de ".$usuario->objetos[0]->email.' a '.$email.'. ';
        }
        if($telefono!=$usuario->objetos[0]->telefono){
            $datos_cambiados.="Su telefono cambió de ".$usuario->objetos[0]->telefono.' a '.$telefono.'. ';
        }
        if($avatar!=''){
            $datos_cambiados='su avatar fue cambiado';
            $nombre=uniqid().'-'.$avatar;
            $ruta='../Util/Img/Users/'.$nombre;
            /* Mover o envie un archivo a otra carpeta*/
            move_uploaded_file($_FILES['avatar_mod']['tmp_name'],$ruta);
            $usuario->obtenerDatos($id_usuario);
            foreach($usuario->objetos as $objeto){
                $avatar_actual=$objeto->avatar;
                if($avatar_actual!='user_default.png'){
                    unlink('../Util/Img/Users/'.$avatar_actual);
                }
            }
            $_SESSION['avatar']=$nombre;
        }else{
            $nombre='';

        }
        $usuario-> actualizarDatosPersonales($id_usuario,$nombres,$apellidos,$dni,$email,$telefono,$nombre);
        $descripcion="Ah editado sus datos personales, ".$datos_cambiados;
        $historial->crearHistorial($descripcion,1,1,$id_usuario);
        echo 'success';

    }else{
        echo 'danger';
    }
    
}
/*Comprobar contraseña - RECIBIR DATOS DE VIEWS */
if($_POST['funcion']=="cambiarContra"){
    $id_usuario=$_SESSION['id'];
    $user=$_SESSION['user'];
    $pass_old = $_POST['pass_old'];
    $pass_new=$_POST['pass_new'];
    $usuario -> verificarUsuario($user);
    if(!empty($usuario->objetos)){
        $pass_bd=openssl_decrypt($usuario->objetos[0]->password,CODE,KEY);
        if($pass_bd==$pass_old){
            $pass_new_encriptada=openssl_encrypt($pass_new,CODE,KEY);
            /*Metodo para cambiar contraseña*/ 
            $usuario->cambiarContrasena($id_usuario, $pass_new_encriptada);
            $descripcion="Ha cambiado su contraseña.";
            $historial->crearHistorial($descripcion,1,1,$id_usuario);
            echo 'success';

        }else{
            echo 'error';

        }
    }else{
        echo 'error';
    }
}