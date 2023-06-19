<?php

include_once 'Conexion.php';
class Historial{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    function llenarHistorial($user){
        $sql=" SELECT historial.id as id,descripcion,fecha,tipo_historial.nombre as tipo_historial,tipo_historial.icono as th_icono,modulo.nombre as modulo,modulo.icono as m_icono from historial JOIN tipo_historial ON tipo_historial.id=historial.id_tipo_historial JOIN modulo ON historial.id_modulo=modulo.id WHERE id_usuario=:id_usuario ORDER BY fecha DESC;";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_usuario'=>$user));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }
    function crearHistorial($descripcion,$tipo_historial,$modulo,$id_usuario){
        $sql="INSERT INTO historial(descripcion,id_tipo_historial,id_modulo,id_usuario)VALUES(:descripcion,:tipo_historial,:modulo,:id_usuario)";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':descripcion'=>$descripcion,':tipo_historial'=>$tipo_historial,':modulo'=>$modulo,':id_usuario'=>$id_usuario));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }

}



  