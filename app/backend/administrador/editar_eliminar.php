<?php
require_once '../../helpers/conexion_bd.php';

header('Content-Type: application/json');

// Verificar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Verificar acción
if (!isset($_POST['accion'])) {
    echo json_encode(['success' => false, 'error' => 'No se especificó una acción']);
    exit;
}

$correo = $_POST['correo'] ?? '';

if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Correo inválido o no proporcionado']);
    exit;
}

function eliminar_usuario($conexion, $correo)
{
    $consulta = "UPDATE usuarios SET estado = 'inactivo' WHERE correo = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->bind_param('s', $correo);

    if ($sentencia->execute()) {
        $sentencia->close();
        return ['success' => true, 'message' => 'Usuario eliminado correctamente'];
    } else {
        error_log("Error al eliminar usuario: " . $sentencia->error);
        $sentencia->close();
        return ['success' => false, 'error' => 'Error en la base de datos'];
    }
}

function editar_usuario($conexion, $correo_original)
{
    if (!isset($_POST['nombre'], $_POST['correo_nuevo'], $_POST['rol'], $_POST['area'])) {
        return ['success' => false, 'error' => 'Faltan datos requeridos'];
    }

    $nombre = trim($_POST['nombre']);
    $correo_nuevo = trim($_POST['correo_nuevo']);
    $rol = trim($_POST['rol']);
    $area = trim($_POST['area']);

    if (!filter_var($correo_nuevo, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'error' => 'Correo electrónico no válido'];
    }

    $roles_permitidos = ['administrador', 'auditor', 'documentador']; 
    if (!in_array(strtolower($rol), $roles_permitidos)) {
        return ['success' => false, 'error' => 'Rol no válido'];
    }

    if (empty($nombre) || empty($area)) {
        return ['success' => false, 'error' => 'Todos los campos son requeridos'];
    }

    // Verificar duplicado de correo
    if ($correo_nuevo !== $correo_original) {
        $consulta_correo = "SELECT correo FROM usuarios WHERE correo = ?";
        $sentencia_correo = $conexion->prepare($consulta_correo);
        $sentencia_correo->bind_param("s", $correo_nuevo);
        $sentencia_correo->execute();
        $result_correo = $sentencia_correo->get_result();

        if ($result_correo->num_rows > 0) {
            $sentencia_correo->close();
            return ['success' => false, 'error' => 'El correo electrónico ya está en uso por otro usuario'];
        }
        $sentencia_correo->close();
    }

    // Obtener id_area
    $consulta_area = "SELECT id_area FROM area_acceso WHERE nombre = ?";
    $sentencia_area = $conexion->prepare($consulta_area);
    $sentencia_area->bind_param("s", $area);
    $sentencia_area->execute();
    $result_area = $sentencia_area->get_result();

    if ($row_area = $result_area->fetch_assoc()) {
        $id_area = $row_area['id_area'];
        $sentencia_area->close();

        $consulta_editar = "UPDATE usuarios SET nombres = ?, correo = ?, rol = ?, id_area = ? WHERE correo = ?";
        $sentencia = $conexion->prepare($consulta_editar);
        $sentencia->bind_param("sssis", $nombre, $correo_nuevo, $rol, $id_area, $correo_original);

        if ($sentencia->execute()) {
            $resultado = $sentencia->affected_rows > 0
                ? ['success' => true, 'message' => 'Usuario editado correctamente']
                : ['success' => false, 'error' => 'No se encontró el usuario o no se realizaron cambios'];
            $sentencia->close();
            return $resultado;
        } else {
            error_log("Error al editar usuario: " . $sentencia->error);
            $sentencia->close();
            return ['success' => false, 'error' => 'Error en la base de datos'];
        }
    } else {
        $sentencia_area->close();
        return ['success' => false, 'error' => 'Área no encontrada'];
    }
}

// Ejecutar acción
switch ($_POST['accion']) {
    case 'eliminar_usuario':
        $resultado = eliminar_usuario($conexion_metadocs, $correo);
        break;

    case 'editar_usuario':
        $resultado = editar_usuario($conexion_metadocs, $correo);
        break;

    default:
        $resultado = ['success' => false, 'error' => 'Acción no válida'];
        break;
}


echo json_encode($resultado);
