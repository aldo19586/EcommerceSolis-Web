<?php
include_once '../Models/Historial.php';

$historial = new Historial();
session_start();
/*LLenar historial - RECIBIR DE VIEWS & ENVIAR DATOS A MODELS */
if($_POST['funcion']=='llenarHistorial'){
    $id_usuario=$_SESSION['id'];
    $historial->llenarHistorial($id_usuario);
    $bandera="";
    $contador=0;
    $fechas=array();
    /*Recorremos el historial*/
    foreach($historial->objetos as $objeto){
        /*Metodo agrupar por fecha*/
        $fecha_hora=date_create($objeto->fecha);
        $hora=$fecha_hora->format('H:i:s');
        $fecha=date_format($fecha_hora,'d-m-Y');
        if($fecha!=$bandera){
            $contador++;
            $bandera=$fecha;

        }
        if($contador==4){
            $fechas[$contador-1][]=array(
                'id'=>$objeto->id,
                'descripcion'=>$objeto->descripcion,
                'fecha'=>$fecha,
                'hora'=>$hora,
                'tipo_historial'=>$objeto->tipo_historial,
                'th_icono'=>$objeto->th_icono,
                'modulo'=>$objeto->modulo,
                'm_icono'=>$objeto->m_icono
            );


        }else{
            if($contador==5){
                break;

            }else{
                $fechas[$contador-1][]=array(
                    'id'=>$objeto->id,
                    'descripcion'=>$objeto->descripcion,
                    'fecha'=>$fecha,
                    'hora'=>$hora,
                    'tipo_historial'=>$objeto->tipo_historial,
                    'th_icono'=>$objeto->th_icono,
                    'modulo'=>$objeto->modulo,
                    'm_icono'=>$objeto->m_icono
                );

            }
        }
    }
    $jsonString=json_encode($fechas);
    echo $jsonString;

}
 