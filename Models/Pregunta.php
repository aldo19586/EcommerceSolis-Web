<?php

include_once 'Conexion.php';
class Pregunta{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    //Funcion leer
    function read($id_producto_tienda){
        $sql="SELECT p.id AS id, 
                     contenido,
                     p.fecha_creacion AS fecha_creacion,
                     p.respuesta AS estado_respuesta,
                     u.id AS id_usuario,
                     u.user AS username,
                     u.avatar AS avatar 
                FROM pregunta AS p
                JOIN producto_tienda AS pt 
                ON p.id_producto_tienda = pt.id
                JOIN usuario AS u
                ON p.id_usuario=u.id
                WHERE pt.id=:id_producto_tienda
                AND p.estado='A' ORDER BY p.fecha_creacion DESC";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_producto_tienda'=>$id_producto_tienda));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }
    function create($pgt,$id_producto_tienda,$id_usuario){
        $sql="INSERT INTO pregunta(contenido,id_producto_tienda,id_usuario)VALUES(:pgt,:id_producto_tienda,:id_usuario) ";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':pgt'=>$pgt,':id_producto_tienda'=>$id_producto_tienda,':id_usuario'=>$id_usuario));

    }
    function readPropietarioPregunta($id_pregunta){
        $sql="SELECT p.id_usuario AS id
                FROM pregunta AS p
                WHERE p.id=:id_pregunta
                AND p.estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_pregunta'=>$id_pregunta));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }

}