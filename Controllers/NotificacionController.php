<?php
include_once '../Models/Notificacion.php';
include_once '../Models/Historial.php';
include_once '../Util/Config/config.php';
//MODELOS
$notificacion=new Notificacion();
$historial=new Historial();
//
session_start();
if($_POST['funcion']=='readNotificaciones'){
   if(!empty($_SESSION['id'])){
    $id_usuario=$_SESSION['id'];
    $notificacion->read($id_usuario);
    //var_dump($notificacion);
    //Inicializamos con vacio porque el usuario puede q no tenga una notificacion
    $json=array();
    foreach($notificacion->objetos as $objeto){
        $json[]=array(
            'id'=>openssl_encrypt($objeto->id,CODE,KEY),
            'titulo'=>$objeto->titulo,
            'asunto'=>$objeto->asunto,
            'contenido'=>$objeto->contenido,
            'imagen'=>$objeto->imagen,
            'url_1'=>$objeto->url_1,
            'fecha_creacion'=>$objeto->fecha_creacion,
        );
    }
    $jsonString=json_encode($json);
    echo $jsonString;
   }else{
    echo 'error, el usuario no sta en session';
   }
}
if($_POST['funcion']=='readAllNotificaciones'){
    if(!empty($_SESSION['id'])){
     $id_usuario=$_SESSION['id'];
     $notificacion->readAllNotificaciones($id_usuario);
     //var_dump($notificacion);
     //Inicializamos con vacio porque el usuario puede q no tenga una notificacion
     $json=array();
     foreach($notificacion->objetos as $objeto){
         $json[]=array(
             'id'=>openssl_encrypt($objeto->id,CODE,KEY),
             'titulo'=>$objeto->titulo,
             'asunto'=>$objeto->asunto,
             'contenido'=>$objeto->contenido,
             'imagen'=>$objeto->imagen,
             'url_1'=>$objeto->url_1,
             'fecha_creacion'=>$objeto->fecha_creacion,
             'estado_abierto'=>$objeto->estado_abierto,
         );
     }
     $jsonString=json_encode($json);
     echo $jsonString;
    }else{
     echo 'error, el usuario no sta en session';
    }
 }
 if($_POST['funcion']=='eliminarNotificacion'){
    if(!empty($_SESSION['id'])){
        $id_usuario=$_SESSION['id'];
        $id_notificacion_encrypted=$_POST['id_notificacion'];
        $formateado=str_replace(" ","+",$id_notificacion_encrypted);
        //Desencryptando
        $id_notificacion= openssl_decrypt($formateado,CODE,KEY);
        $mensaje='';
        if(is_numeric($id_notificacion)){
            $notificacion->updateRemove($id_notificacion);
            $descripcion = 'Eliminaste una notificacion';
            $historial->crearHistorial($descripcion,3,4,$id_usuario);
            $mensaje='Notificacion eliminada';

        }else{
            $mensaje='Error al eliminar';
        }
        $json=array('mensaje1'=>$mensaje);
        $jsonString=json_encode($json);
        echo $jsonString;
    }else{
     echo 'error, el usuario no sta en session';
    }
 }