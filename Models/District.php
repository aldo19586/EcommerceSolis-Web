<?php

include_once 'Conexion.php';
class Distrito{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    function llenarDistrito($id_provincia){
        $sql="SELECT * FROM distrito
                WHERE id_provincia=:id";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id'=>$id_provincia));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }
    
}