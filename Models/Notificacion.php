<?php

include_once 'Conexion.php';
class Notificacion{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    
    function create($titulo,$asunto,$pgt,$imagen,$url,$id_propietario_tienda){
        $sql="INSERT INTO notificacion(titulo,asunto,contenido,imagen,url_1,id_usuario)VALUES(:titulo,:asunto,:contenido,:imagen,:url_1,:id_usuario) ";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':titulo'=>$titulo,':asunto'=>$asunto,':contenido'=>$pgt,':imagen'=>$imagen,':url_1'=>$url,':id_usuario'=>$id_propietario_tienda));

    }
    function read($id_usuario){
        $sql="SELECT *
                FROM notificacion AS n
                WHERE n.id_usuario=:id_usuario
                AND n.estado='A'
                AND n.estado_abierto=0
                ORDER BY n.fecha_creacion DESC";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_usuario'=>$id_usuario));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }
    function updateEstadoAbierto($noti){
        $sql="UPDATE notificacion SET estado_abierto=1 WHERE id=:id_noti";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_noti'=>$noti));

    }
    function readAllNotificaciones($id_usuario){
        $sql="SELECT *
                FROM notificacion AS n
                WHERE n.id_usuario=:id_usuario
                AND n.estado='A'
                ORDER BY n.fecha_creacion DESC";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_usuario'=>$id_usuario));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;

    }
    function updateRemove($id_notificacion){
        $sql="UPDATE notificacion SET estado=:estado WHERE id=:id_notificacion";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_notificacion'=>$id_notificacion,':estado'=>'I'));

    }

}