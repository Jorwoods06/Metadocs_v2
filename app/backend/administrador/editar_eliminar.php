<?php

require_once '../../helpers/conexion_bd.php';

// Asegurar que la respuesta sea JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
} else {
    
    if (!isset($_POST['accion'])) {
        echo json_encode(['success' => false, 'error' => 'No se especificó una acción']);
        exit;
    }

    $correo = $_POST['correo'] ?? '';
    
    if (empty($correo)) {
        echo json_encode(['success' => false, 'error' => 'Correo no proporcionado']);
        exit;
    }

    function eliminar_usuario($conexion, $correo){
        $consulta = "UPDATE usuarios SET estado = 'inactivo' WHERE correo = ?";
        $sentencia = $conexion->prepare($consulta); 
        $sentencia->bind_param('s', $correo);

        if ($sentencia->execute()) {
            $sentencia->close();
            return ['success' => true, 'message' => 'Usuario eliminado correctamente'];
        } else {
            $error = $sentencia->error;
            $sentencia->close();
            return ['success' => false, 'error' => 'Error en la base de datos: ' . $error];
        }
    }

    switch ($_POST['accion']) {
        case 'eliminar_usuario':
            $resultado = eliminar_usuario($conexion_metadocs, $correo);
            echo json_encode($resultado);
            break;
        default:
            echo json_encode(['success' => false, 'error' => 'Acción no válida']);
            break;
    }
}

?>