<?php
include_once '../Models/Province.php';
$provincia = new Provincia();
session_start();
if($_POST['funcion']=='llenarProvincia'){
   $id_departamento=$_POST['id_departamento'];
   $provincia->llenarProvincia($id_departamento);
   $json=array();
   foreach ($provincia ->objetos as $objeto ) {
    $json[]=array(
        'id'=>$objeto->id,
        'nombre'=>$objeto->nombre,
    );
   }
   $jsonString = json_encode($json);
   echo $jsonString;
}