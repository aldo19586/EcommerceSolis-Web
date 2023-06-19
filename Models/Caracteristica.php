<?php

include_once 'Conexion.php';
class Caracteristica{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    //Funcion pa poder promediar las calificaciones
    function capturarCaracteristicas($id_producto){
        $sql="SELECT
                 *
                    FROM caracteristica AS c
                    WHERE c.id_producto=:id_producto
                    AND c.estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_producto'=>$id_producto));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }  
}