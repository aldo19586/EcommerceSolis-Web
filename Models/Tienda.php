<?php

include_once 'Conexion.php';
class Tienda{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    function contarResenas($id_tienda,$id_producto){
        $sql="SELECT
                 COUNT(*) AS numero_resenas,
                 AVG(calificacion) AS sumatoria
                    FROM tienda AS t
                    JOIN producto_tienda AS pt ON t.id=pt.id_tienda
                    JOIN resena AS r ON pt.id=r.id_producto_tienda
                    AND t.id=:id_tienda AND pt.id_producto=:id_producto";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_tienda'=>$id_tienda,':id_producto'=>$id_producto));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }
}