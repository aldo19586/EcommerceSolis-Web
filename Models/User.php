<?php

include_once 'Conexion.php';
class Usuario{
    //Funciones del usuario
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }
    
    /*Cuando la contraseña no esta encryptada
    function loguearse($user,$pass){
        $sql="SELECT * FROM usuario 
                 WHERE user=:user and password=:pass ";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':user'=>$user,':pass'=>$pass));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }*/
    function verificarUsuario($user){
        $sql="SELECT * FROM usuario 
                 WHERE user=:user ";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':user'=>$user));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }
    function registrarUsuario($username,$pass,$nombres,$apellidos,$dni,$email,$telefono){
        $sql="INSERT INTO usuario(user,password,nombres,apellidos,dni,email,telefono,id_tipo)VALUES(:user,:pass,:nombres,:apellidos,:dni,:email,:telefono,:id_tipo) ";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':user'=>$username,':pass'=>$pass,':nombres'=>$nombres,':apellidos'=>$apellidos,':dni'=>$dni,':email'=>$email,':telefono'=>$telefono,':id_tipo'=>2));

    }
    function obtenerDatos($user){
        $sql="SELECT * FROM usuario 
                 JOIN tipousuario 
                 ON usuario.id_tipo=tipousuario.id
                 WHERE usuario.id=:user";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':user'=>$user));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }
    function actualizarDatosPersonales($id_usuario,$nombres,$apellidos,$dni,$email,$telefono,$nombre){
        if($nombre!=''){
            $sql="UPDATE usuario SET
            nombres=:nombres,
            apellidos=:apellidos,
            dni=:dni,
            email=:email,
            telefono=:telefono,
            avatar=:avatar
            WHERE id=:id_usuario ";
            $query = $this -> acceso -> prepare($sql);
            $variables=array(
            ':id_usuario'=>$id_usuario,
            ':nombres'=>$nombres,
            ':apellidos'=>$apellidos,
            ':dni'=>$dni,
            ':email'=>$email,
            ':telefono'=>$telefono,
            ':avatar'=>$nombre
            );
            $query -> execute($variables);

        }else{
            $sql="UPDATE usuario SET
            nombres=:nombres,
            apellidos=:apellidos,
            dni=:dni,
            email=:email,
            telefono=:telefono
            WHERE id=:id_usuario ";
            $query = $this -> acceso -> prepare($sql);
            $variables=array(
            ':id_usuario'=>$id_usuario,
            ':nombres'=>$nombres,
            ':apellidos'=>$apellidos,
            ':dni'=>$dni,
            ':email'=>$email,
            ':telefono'=>$telefono,
            );
            $query -> execute($variables);

        }

    }
    /*//para comprobar la contra sin encryptar
    function comprobarContrasena($id_usuario,$pass_old){
        $sql="SELECT * FROM usuario WHERE id=:id_usuario AND password=:pass_old ";
        $query = $this -> acceso -> prepare($sql);
        $query -> execute(array(':id_usuario'=>$id_usuario,':pass_old'=>$pass_old));
        $this -> objetos = $query -> fetchAll();
        return $this -> objetos;
    }*/

    function cambiarContrasena($id_usuario,$pass_new){
        $sql="UPDATE usuario SET password=:pass_new WHERE id=:id_usuario";
        $query = $this -> acceso -> prepare($sql);
        $variables=array(
        ':id_usuario'=>$id_usuario,
        ':pass_new'=>$pass_new,
        );
        $query -> execute($variables);

    }

}


    