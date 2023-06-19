<?php

include_once 'Conexion.php';
class Resena{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    //Funcion pa poder promediar las calificaciones
    function evaluarCalificaciones($id_producto_tienda){
        
        $sql="SELECT
                AVG(calificacion) AS promedio
                    FROM resena AS r
                    WHERE r.id_producto_tienda =:id_producto_tienda 
                    AND r.estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_producto_tienda'=>$id_producto_tienda));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }
    function capturarResenas($id_producto_tienda){
        $sql="SELECT
                 r.id AS id,
                 calificacion,
                 descripcion,
                 fecha_creacion,
                 user,
                 u.avatar as avatar
                    FROM resena AS r
                    JOIN usuario AS u
                    ON u.id=r.id_usuario
                    WHERE r.id_producto_tienda=:id_producto_tienda
                    AND r.estado='A' ORDER BY r.fecha_creacion DESC";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_producto_tienda'=>$id_producto_tienda));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }    
    
    
    
}