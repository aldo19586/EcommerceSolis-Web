<?php

include_once 'Conexion.php';
class UsuarioDistrito{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    function crearDireccion($id_usuario,$id_distrito,$direccion,$referencia){
        $sql="INSERT INTO usuario_distrito(direccion,referencia,id_distrito,id_usuario)VALUES(:direccion,:referencia,:id_distrito,:id_usuario) ";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':direccion'=>$direccion,':referencia'=>$referencia,':id_distrito'=>$id_distrito,':id_usuario'=>$id_usuario));
    }
    function obtenerDatosDirecciones($id_usuario){
        $sql="SELECT ud.id as id,ud.direccion as direccion,ud.referencia as referencia,d.nombre as distrito,p.nombre as provincia,de.nombre as departamento FROM usuario_distrito as ud
                 JOIN distrito as d ON d.id=ud.id_distrito
                 JOIN provincia as p ON p.id =d.id_provincia
                 JOIN departamento as de ON de.id=p.id_departamento 
                 WHERE id_usuario=:id and estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id'=>$id_usuario));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }
    function eliminarDireccion($id_direccion){
        $sql="UPDATE usuario_distrito SET estado='I' WHERE id=:id_direccion";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_direccion'=>$id_direccion));
    }
    function recuperarDireccion($id_direccion){
        $sql="SELECT ud.id as id,ud.direccion as direccion,ud.referencia as referencia,d.nombre as distrito,p.nombre as provincia,de.nombre as departamento FROM usuario_distrito as ud
                 JOIN distrito as d ON d.id=ud.id_distrito
                 JOIN provincia as p ON p.id =d.id_provincia
                 JOIN departamento as de ON de.id=p.id_departamento 
                 WHERE ud.id=:id and estado='A'";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id'=>$id_direccion));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }

}