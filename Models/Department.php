<?php

include_once 'Conexion.php';
class Departamento{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    function llenarDepartamento(){
        $sql="SELECT * FROM departamento";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute();
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }
    
}


    