<?php
include_once '../Models/ProductStore.php';
include_once '../Models/Pregunta.php';
include_once '../Models/Notificacion.php';
include_once '../Models/Historial.php';
include_once '../Util/Config/config.php';

//MODELOS
$producto_tienda = new ProductoTienda();
$pregunta=new Pregunta();
$notificacion=new Notificacion();
$historial= new Historial();
//
session_start();
if($_POST['funcion']=='realizarPregunta'){
   if(!empty($_SESSION['id'])){
    $pgt=$_POST['pregunta'];
    $id_usuario=$_SESSION['id'];
    //Metodo para reemplazar ciertos datos de una cadena.(el dato a q se va a reemplazar,el dato reemplazo,cadena analizada)
    $formateado=str_replace(" ","+",$_SESSION['product-verification']);
    //Desencryptando
    $id_producto_tienda= openssl_decrypt($formateado,CODE,KEY);
    $pregunta->create($pgt,$id_producto_tienda,$id_usuario);
    ///Para crear NOTIFICACIONES///
    $producto_tienda->llenarProductos($id_producto_tienda);
    //Traer datos de la BD
    //El id del dueño
    $id_propietario_tienda=$producto_tienda->objetos[0]->id_usuario;
    //El titulo
    $titulo=$producto_tienda->objetos[0]->producto;
    //La imagen
    $imagen=$producto_tienda->objetos[0]->imagen;
    //El asunto
    $asunto='Alquien realizo una pregunta en tu producto';
    //El url
    $url='Views/description.php?name='.$titulo.'&&id='.$formateado;
    $notificacion->create($titulo,$asunto,$pgt,$imagen,$url,$id_propietario_tienda);
    $descripcion = 'Ha realizado una pregunta: "'.$pgt.'" | Producto: '.$titulo;
    $historial->crearHistorial($descripcion,2,3,$id_usuario);
    $json=array(
        'mensaje1'=>'pregunta creada',
        'mensaje2'=>'notificacion creada',
        'mensaje3'=> 'historial creada'
    );  
    $jsonString=json_encode($json);
    echo $jsonString;
   }else{
    echo 'error, el usuario no sta en session';
   }
}