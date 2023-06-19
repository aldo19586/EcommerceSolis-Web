<?php
include_once '../Models/ProductStore.php';
include_once '../Models/Pregunta.php';
include_once '../Models/Respuesta.php';
include_once '../Models/Historial.php';
include_once '../Models/Notificacion.php';
include_once '../Util/Config/config.php';

//MODELOS
$producto_tienda = new ProductoTienda();
$pregunta=new Pregunta();
$respuesta= new Respuesta();
$notificacion= new Notificacion();
$historial= new Historial();
//
session_start();
if($_POST['funcion']=='realizarRespuesta'){
   if(!empty($_SESSION['id'])){
    $resp=$_POST['respuesta'];
    $id_usuario=$_SESSION['id'];
    $id_pregunta=$_POST['id_pregunta'];
    $respuesta->create($resp,$id_pregunta);
    ///Para crear NOTIFICACIONES///
    //Traemos el id 
    $formateado=str_replace(" ","+",$_SESSION['product-verification']);
    $id_producto_tienda= openssl_decrypt($formateado,CODE,KEY);
    $producto_tienda->llenarProductos($id_producto_tienda);
    //Traer datos de la BD
    //El titulo
    $titulo=$producto_tienda->objetos[0]->producto;
    //La imagen
    $imagen=$producto_tienda->objetos[0]->imagen;
    //El asunto
    $asunto='El vendedor te respondió';
    //El url
    $url='Views/description.php?name='.$titulo.'&&id='.$formateado;
    $pregunta->readPropietarioPregunta($id_pregunta);
    $id_propietario_pregunta=$pregunta->objetos[0]->id;
    $notificacion->create($titulo,$asunto,$resp,$imagen,$url,$id_propietario_pregunta);

    $descripcion = 'Ha realizado una respuesta: "'.$resp.'" | Producto: '.$titulo;
    $historial->crearHistorial($descripcion,2,3,$id_usuario);

    $json=array(
        'mensaje'=>'Respuesta creada',
        'mensaje2'=>'Notificacion creada',
        'mensaje3'=> 'historial creada'
    );
    $jsonString=json_encode($json);
    echo $jsonString;
   }else{
    echo 'error, el usuario no sta en session';
   }
}