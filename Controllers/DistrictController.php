<?php
include_once '../Models/District.php';
$distrito = new Distrito();
session_start();
if($_POST['funcion']=='llenarDistrito'){
   $id_provincia=$_POST['id_provincia'];
   $distrito->llenarDistrito($id_provincia);
   $json=array();
   foreach ($distrito ->objetos as $objeto ) {
    $json[]=array(
        'id'=>$objeto->id,
        'nombre'=>$objeto->nombre,
    );
   }
   $jsonString = json_encode($json);
   echo $jsonString;
}