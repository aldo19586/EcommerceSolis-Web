<?php
include_once '../Models/Department.php';
$departamento = new Departamento();
session_start();
if($_POST['funcion']=='llenarDepartamento'){
   $departamento->llenarDepartamento();
   foreach ($departamento ->objetos as $objeto ) {
    $json[]=array(
        'id'=>$objeto->id,
        'nombre'=>$objeto->nombre,
    );
   }
   $jsonString = json_encode($json);
   echo $jsonString;
}