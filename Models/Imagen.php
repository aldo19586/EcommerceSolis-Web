<?php

include_once 'Conexion.php';
class Imagen{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    //Funcion pa poder promediar las calificaciones
    //Funcion pa traer imagenes de la BD
    function capturarImagenes($id_producto){
        $sql="SELECT
                 *
                    FROM imagen
                    WHERE imagen.id_producto=:id_producto
                    AND imagen.estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_producto'=>$id_producto));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }
    
    
}