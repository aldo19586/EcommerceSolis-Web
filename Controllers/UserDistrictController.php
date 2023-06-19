<?php
include_once '../Models/UserDistrict.php';
include_once '../Models/Historial.php';
include_once '../Util/Config/config.php';
$usuario_distrito = new UsuarioDistrito();
$historial= new Historial();
session_start();
/*Iniciar la Sesion*/
if($_POST['funcion']=='direccion'){
    /*Recibir datos de Views*/
    $id_usuario=$_SESSION['id'];
    $id_distrito=$_POST['id_distrito'];
    $direccion=$_POST['direccion'];
    $referencia=$_POST['referencia'];
    $usuario_distrito -> crearDireccion($id_usuario,$id_distrito,$direccion,$referencia);
    $descripcion='Ha creado una nueva dirección: '.$direccion;
    $historial-> crearHistorial($descripcion,2,1,$id_usuario);
    echo 'success';
}
/*Obtener datos de las direcciones*/
if($_POST['funcion']=='obtenerDatosDirecciones'){
    $id_usuario=$_SESSION['id'];
    $usuario_distrito->obtenerDatosDirecciones($id_usuario);
    
    foreach ($usuario_distrito->objetos as $objeto ) {
        $json[]=array(
            /*Enviar datos a Views*/
            'id'=>openssl_encrypt($objeto->id,CODE,KEY),
            'direccion'=>$objeto->direccion,
            'referencia'=>$objeto->referencia,
            'departamento'=>$objeto->departamento,
            'provincia'=>$objeto->provincia,
            'distrito'=>$objeto->distrito,
        );
       }
       $jsonString = json_encode($json);
       echo $jsonString;
}
/*Eliminar direcciones*/
if($_POST['funcion']=='eliminarDireccion'){
    //Encriptar el id
    $id_direccion= openssl_decrypt($_POST['id'],CODE,KEY);
    if(is_numeric($id_direccion)){
        //Recuperar datos pa poner en el tapline
        $usuario_distrito -> recuperarDireccion($id_direccion);
        $direccion_borrada = $usuario_distrito ->objetos[0]->direccion;
        $usuario_distrito -> eliminarDireccion($id_direccion);
        $descripcion='Ha eliminado la direccion: '.$direccion_borrada;
        $historial->crearHistorial($descripcion,3,1,$_SESSION['id']);
        echo 'success';
    }else{
        echo 'error';
    } ;
    
}