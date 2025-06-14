<?php
require_once '../../helpers/conexion_bd.php';

$id_expediente = $_POST['datos_expediente'];


function aprobarExpediente($conexion, $id_expediente) {
    $sql_aprobar = "UPDATE `expedientes` SET `estado` = 'aprobado' WHERE `id_expediente` = ?;";

    if ($sentencia = $conexion->prepare($sql_aprobar)) {
        $sentencia->bind_param('i', $id_expediente);

        if ($sentencia->execute()) {
            return true;
        } else {
            error_log("Error al ejecutar la consulta: " . $sentencia->error);
            return false;
        }
        $sentencia->close();
    } else {
        error_log("Error al preparar la consulta: " . $conexion->error);
        return false;
    }
}





if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo "tu peticion ha sido rechazada ";

}else{

  switch($_POST['accion']){

    case 'aprobar_expediente':

        if(aprobarExpediente($conexion_metadocs, $id_expediente)){
             header("Location: ../../vistas/auditor/recibir_documentos.php?sucess=true");
        }else{
            header("Location: ../../vistas/auditor/recibir_documentos.php?error=true");
        }

        break;

  }

}

?>