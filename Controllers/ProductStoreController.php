<?php
include_once '../Models/ProductStore.php';
include_once '../Models/Resena.php';
include_once '../Models/Imagen.php';
include_once '../Models/Tienda.php';
include_once '../Models/Caracteristica.php';
include_once '../Models/Pregunta.php';
include_once '../Models/Respuesta.php';
include_once '../Models/Notificacion.php';
include_once '../Util/Config/config.php';
//MODELOS
$producto_tienda = new ProductoTienda();
$resena=new Resena();
$img=new Imagen();
$tnd=new Tienda();
$pregunta=new Pregunta();
$caracteristica=new Caracteristica();
$respuesta= new Respuesta();
$notificacion=new Notificacion();
//
session_start();
if($_POST['funcion']=='llenarProductos'){
   $producto_tienda->llenarProductos();
   //var_dump($producto_tienda);
   $json=array();
   foreach ($producto_tienda ->objetos as $objeto ) {
    $resena->evaluarCalificaciones($objeto->id);
    $json[]=array(
        //Metodo incriptacion
        'id'=>openssl_encrypt($objeto->id,CODE,KEY),
        'producto'=>$objeto->producto,
        'imagen'=>$objeto->imagen,
        'calificacion'=>number_format($resena->objetos[0]->promedio),
        'marca'=>$objeto->marca,
        'envio'=>$objeto->envio,
        'precio'=>$objeto->precio,
        'descuento'=>$objeto->descuento,
        'precio_descuento'=>$objeto->precio_descuento,
    );
   }
   $jsonString = json_encode($json);
   echo $jsonString;
}
if($_POST['funcion']=='verificarProducto'){
    //Metodo para reemplazar ciertos datos de una cadena.'el dato a q se va a reemplazar,el dato reemplazo,cadena analizada'
    $formateado=str_replace(" ","+",$_SESSION['product-verification']);
    //Desencryptando
    $id_producto_tienda= openssl_decrypt($formateado,CODE,KEY);
    //Verificar si el dato es numero
    if(is_numeric($id_producto_tienda)){
        //Verificar si existe la sesion notificación
        if(!empty($_SESSION['noti'])){
            //Cambiar el estado de la notificacion
            //Desencriptadno la sesion noti
            $noti_formateado=str_replace(" ","+",$_SESSION['noti']);
            //Desencryptando
            $id_noti= openssl_decrypt($noti_formateado,CODE,KEY);
            //Validar q sea siempre un numero
            if(is_numeric($id_noti)){
                $notificacion->updateEstadoAbierto($id_noti);
                //Metodo para borrar sesion
                unset($_SESSION['noti']);
            }
        }
        $producto_tienda->llenarProductos($id_producto_tienda);
        //No es necesario hacer un foreach xq tenemos un registro
        $id_producto=$producto_tienda->objetos[0]->id_producto;
        $producto=$producto_tienda->objetos[0]->producto;
        $sku=$producto_tienda->objetos[0]->sku;
        $detalles=$producto_tienda->objetos[0]->detalles;
        $imagen=$producto_tienda->objetos[0]->imagen;
        $marca=$producto_tienda->objetos[0]->marca;
        $envio=$producto_tienda->objetos[0]->envio;
        $precio=$producto_tienda->objetos[0]->precio;
        $descuento=$producto_tienda->objetos[0]->descuento;
        $precio_descuento=$producto_tienda->objetos[0]->precio_descuento;
        $id_tienda=$producto_tienda->objetos[0]->id_tienda;
        //var_dump($producto_tienda);
        $direccion_tienda=$producto_tienda->objetos[0]->direccion;
        $tienda=$producto_tienda->objetos[0]->tienda;
        $id_usuario=$producto_tienda->objetos[0]->id_usuario;
        $username=$producto_tienda->objetos[0]->username;
        $avatar=$producto_tienda->objetos[0]->avatar;
        $resena->evaluarCalificaciones($id_producto_tienda);
        $calificacion=$resena->objetos[0]->promedio;
        //Traer todas las imagenes referentes al producto
        $img->capturarImagenes($id_producto);
        //Creamos un arreglo para imagenes porque tiene varios
        $imagenes= array();
        foreach($img ->objetos as $objeto){
            $imagenes[]=array(
                'id'=>$objeto->id,
                'nombre'=>$objeto->nombre,
            );
        }

        $tnd->contarResenas($id_tienda,$id_producto);
        $numero_resenas=$tnd->objetos[0]->numero_resenas;
        $promedio_calificacion_tienda=$tnd->objetos[0]->sumatoria;
        $caracteristica->capturarCaracteristicas($id_producto);
        //Creamos un arreglo para caracteristicas porque tiene varios
        $caracteristicas= array();
        foreach($caracteristica ->objetos as $objeto){
            $caracteristicas[]=array(
                'id'=>$objeto->id,
                'titulo'=>$objeto->titulo,
                'descripcion'=>$objeto->descripcion,
            );
        }

        $resena->capturarResenas($id_producto_tienda);
        //Creamos un arreglo para resenas porque tiene varios
        $resenas= array();
        foreach($resena ->objetos as $objeto){
            $resenas[]=array(
                'id'=>$objeto->id,
                'calificacion'=>$objeto->calificacion,
                'descripcion'=>$objeto->descripcion,
                'fecha_creacion'=>$objeto->fecha_creacion,
                'usuario'=>$objeto->user,
                'avatar'=>$objeto->avatar
            );
        }
        //Para verificar si hay usuarios registrados
        //Algoritmo para detectar el tipo de usuario que esta navegando
        $id_usuario_sesion=0;
        $usuario_sesion='';
        $avatar_sesion='';
        $bandera='0';
        if(!empty($_SESSION['id'])){
            $id_usuario_sesion=1;
        }
        if($id_usuario_sesion==1){
            if($id_usuario==$_SESSION['id']){
                //El usuario en sesion es dueño de la tienda o producto
                //Puedo responder preguntas
                //No puedo hacer preguntas
                $bandera='1';
                $usuario_sesion=$_SESSION['id'];
                $avatar_sesion=$_SESSION['avatar'];
            }else{
                //El usuario en sesion es cualquier menos el dueño
                //No puedo responder preguntas
                //Puedo hacer preguntas
                $bandera='2';
            }
        }else{
            //El usuario no tiene sesion
            //No puedo responder ni hacer preguntas
            $bandera='0';
        }
        $pregunta->read($id_producto_tienda);
        $preguntas=array();
        foreach($pregunta->objetos as $objeto){
            $respuesta->read($objeto->id);
            $rpst=array();
            if(!empty($respuesta)){
                //Datos de las respuestas
                foreach($respuesta->objetos as $objeto1){
                    $rpst=array(
                        'id'=>$objeto1->id,
                        'contenido'=>$objeto1->contenido,
                        'fecha_creacion'=>$objeto1->fecha_creacion,
                    );
                }

            }
            $preguntas[]=array(
                //Datos del usuario que hizo las preguntas
                'id'=>$objeto->id,
                'contenido'=>$objeto->contenido,
                'fecha_creacion'=>$objeto->fecha_creacion,
                'estado_respuesta'=>$objeto->estado_respuesta,
                'username'=>$objeto->username,
                'avatar'=>$objeto->avatar,
                'respuesta'=>$rpst
            );
        }


        //Creamos un arreglo para todos los datos de arriba  y poder mandarlo en un json
        $json=array(
                'id'=>$id_producto_tienda,
                'producto'=>$producto,
                'sku'=>$sku,
                'detalles'=>$detalles,
                'imagen'=>$imagen,
                'marca'=>$marca,
                'envio'=>$envio,
                'precio'=>$precio,
                'descuento'=>$descuento,
                'precio_descuento'=>$precio_descuento,
                'calificacion'=>number_format($calificacion),
                'direccion_tienda'=>$direccion_tienda,
                'numero_resenas'=>$numero_resenas,
                'promedio_calificacion_tienda'=>number_format($promedio_calificacion_tienda),
                'tienda'=>$tienda,
                'bandera'=>$bandera,
                //Datos del usuario que es el dueño
                'id_usuario'=>$id_usuario,
                'username'=>$username,
                'avatar'=>$avatar,
                //
                'usuario_sesion'=>$usuario_sesion,
                'avatar_sesion'=>$avatar_sesion,
                'imagenes'=>$imagenes,
                'caracteristicas'=>$caracteristicas,
                'resenas'=>$resenas,
                //Datos del usuario que hizo las preguntas
                'preguntas'=>$preguntas,
             
                //
            );
        
        $jsonString = json_encode($json);
        echo $jsonString;
    }else{
        echo 'error';
    }

    
 }