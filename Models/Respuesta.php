<?php

include_once 'Conexion.php';
class Respuesta{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    //Funcion leer
    function read($id_pregunta){
        $sql="SELECT
                    *
                FROM respuesta AS r
                WHERE r.id_pregunta=:id_pregunta
                AND r.estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_pregunta'=>$id_pregunta));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }
    function create($resp,$id_pregunta){
        $sql="INSERT INTO respuesta(contenido,id_pregunta)VALUES(:resp,:id_pregunta)";
        $query = $this -> acceso -> prepare($sql);
        $variables=array(':resp'=>$resp,':id_pregunta'=>$id_pregunta);
        $query -> execute($variables);
        //Cambiar estado de la pregunta
        $sql="UPDATE pregunta 
                SET respuesta=:estado 
                WHERE id=:id_pregunta";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':estado'=>'1',':id_pregunta'=>$id_pregunta));

    }
}