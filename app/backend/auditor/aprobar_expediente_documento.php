<?php
require_once '../../helpers/conexion_bd.php';

$id_expediente = $_POST['datos_expediente'];
$id_documento = $_POST['datos_documento'];


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

function aprobarDocumento($conexion, $id_documento){
    $sql_aprobar = "UPDATE `documentos` SET `estado` = 'aprobado' WHERE `documentos`.`id_documento` = ?;";
    if($sentencia = $conexion->prepare($sql_aprobar)){
        $sentencia->bind_param('i', $id_documento);
        if ($sentencia->execute()) {
            $sentencia->close();
            return true;
        } else {
            error_log("Error al ejecutar la consulta: " . $sentencia->error);
            $sentencia->close();
            return false;
        }
    } else {
        error_log("Error al preparar la consulta: " . $conexion->error);
        return false; 
    }
}

function rechazarExpediente($conexion, $id_expediente){
    $sql_rechazar = "UPDATE `expedientes` SET `estado` = 'rechazado' WHERE `id_expediente` = ?; ";

    if($sentencia = $conexion->prepare($sql_rechazar)){
        $sentencia -> bind_param('i', $id_expediente);

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

function rechazarDocumento($conexion, $id_documento) {
    // Iniciar transacción
    $conexion->begin_transaction();
    
    try {
        // Primero obtener la ruta del archivo antes de actualizar
        $sql_obtener_path = "SELECT path FROM documentos WHERE id_documento = ?";
        $stmt_path = $conexion->prepare($sql_obtener_path);
        
        if (!$stmt_path) {
            throw new Exception("Error al preparar consulta para obtener path: " . $conexion->error);
        }
        
        $stmt_path->bind_param('i', $id_documento);
        $stmt_path->execute();
        $resultado = $stmt_path->get_result();
        $documento = $resultado->fetch_assoc();
        
        if (!$documento) {
            throw new Exception("Documento no encontrado");
        }
        
        $ruta_archivo = $documento['path'];
        $stmt_path->close();
        
        // Actualizar el estado del documento a rechazado
        $sql_rechazar = 'UPDATE documentos SET estado = "rechazado" WHERE id_documento = ?';
        $sentencia = $conexion->prepare($sql_rechazar);
        
        if (!$sentencia) {
            throw new Exception("Error al preparar la consulta de actualización: " . $conexion->error);
        }
        
        $sentencia->bind_param('i', $id_documento);
        
        if (!$sentencia->execute()) {
            throw new Exception("Error al ejecutar la consulta de actualización: " . $sentencia->error);
        }
        
        $sentencia->close();
        
        // Eliminar el archivo físico si existe
        if (!empty($ruta_archivo) && file_exists($ruta_archivo)) {
            if (!unlink($ruta_archivo)) {
                // Log del error pero no fallar la transacción
                error_log("Advertencia: No se pudo eliminar el archivo físico: " . $ruta_archivo);
            }
        }
        
        // Confirmar la transacción
        $conexion->commit();
        return true;
        
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();
        error_log("Error en rechazarDocumento: " . $e->getMessage());
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

    case 'aprobar_documento':

        if(aprobarDocumento($conexion_metadocs, $id_documento)){
             header("Location: ../../vistas/auditor/recibir_documentos.php?sucess=true");
        }else{
            header("Location: ../../vistas/auditor/recibir_documentos.php?error=true");
        }

        break;

    case  'rechazar_expediente':

        if(rechazarExpediente($conexion_metadocs, $id_expediente)){
            header("Location: ../../vistas/auditor/recibir_documentos.php?sucess=true");
        }else{
            header("Location: ../../vistas/auditor/recibir_documentos.php?error=true");
        }
        break;


    case 'rechazar_documento':

        if (rechazarDocumento($conexion_metadocs, $id_documento)) {
             header("Location: ../../vistas/auditor/recibir_documentos.php?sucess=true");
        }else{
             header("Location: ../../vistas/auditor/recibir_documentos.php?error=true");
        }
        break;

}

}

?>