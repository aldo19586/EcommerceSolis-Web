<?php

include_once 'Conexion.php';
class ProductoTienda{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    function llenarProductos($id=null){
        //Verificar si el id existe para poder esta funcion en verificarProducto
        if($id){
            $sql="SELECT
                pt.id as id,
                p.id as id_producto,
                p.sku as sku,
                p.nombre as producto,
                p.imagen_principal as imagen,
                p.detalles as detalles,
                m.nombre as marca,
                pt.estado_envio as envio,
                pt.precio as precio,
                pt.descuento as descuento,
                pt.precio -(pt.precio*(pt.descuento/100)) as precio_descuento,
                t.id as id_tienda,
                t.nombre as tienda,
                t.direccion as direccion,
                u.id as id_usuario,
                u.user as username,
                u.avatar as avatar
                    FROM producto_tienda as pt
                    JOIN producto as p ON p.id=pt.id_producto
                    JOIN marca as m ON m.id=p.id_marca
                    JOIN tienda as t ON t.id=pt.id_tienda
                    JOIN usuario as u ON u.id=t.id_usuario
                    WHERE pt.estado='A' AND pt.id=:id";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id'=>$id));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
            
        }else{
        //Si no existe el id vamos a poder utilizar esta funcion en llenarProductos
                $sql="SELECT
                pt.id as id,
                p.id as id_producto,
                p.sku as sku,
                p.nombre as producto,
                p.imagen_principal as imagen,
                p.detalles as detalles,
                m.nombre as marca,
                pt.estado_envio as envio,
                pt.precio as precio,
                pt.descuento as descuento,
                pt.precio -(pt.precio*(pt.descuento/100)) as precio_descuento,
                t.id as id_tienda,
                t.nombre as tienda,
                t.direccion as direccion
                    FROM producto_tienda as pt
                    JOIN producto as p ON p.id=pt.id_producto
                    JOIN marca as m ON m.id=p.id_marca
                    JOIN tienda as t ON t.id=pt.id_tienda
                    WHERE pt.estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute();
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
        }
        
    }
    
    
    

}