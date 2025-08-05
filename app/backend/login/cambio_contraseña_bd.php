<?php
header('Content-Type: application/json');

require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';

// Validar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Petición rechazada.']);
    exit;
}

// Verificar que el usuario esté definido correctamente
if (!isset($usuario) || !isset($usuario['id_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no identificado.']);
    exit;
}

$id = $usuario['id_usuario'];
$contraseña_actual = $_POST['currentPassword'] ?? '';
$contraseña_nueva = $_POST['confirmPassword'] ?? '';

// Validar que ambas contraseñas no estén vacías
if (empty($contraseña_actual) || empty($contraseña_nueva)) {
    echo json_encode(['status' => 'error', 'message' => 'Ambas contraseñas son requeridas.']);
    exit;
}

// Consulta para obtener la contraseña actual desde la base de datos
$query = "SELECT contraseña FROM usuarios WHERE id_usuario = ?";
$stmt = mysqli_prepare($conexion_metadocs, $query);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta SELECT.']);
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!$resultado) {
    echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar la consulta SELECT.']);
    exit;
}

$usuario_bd = mysqli_fetch_assoc($resultado);

if (!$usuario_bd) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado.']);
    exit;
}

// Comparar la contraseña actual usando md5
if (md5($contraseña_actual) != $usuario_bd['contraseña']) {
    echo json_encode(['status' => 'error', 'message' => 'La contraseña actual es incorrecta.']);
    exit;
}

// Generar el nuevo hash con md5
$nueva_hash = md5($contraseña_nueva);

// Validar si la contraseña nueva es la misma que la actual
if ($nueva_hash === $usuario_bd['contraseña']) {
    echo json_encode(['status' => 'error', 'message' => 'La nueva contraseña no puede ser igual a la actual.']);
    exit;
}

// Actualizar la contraseña en la base de datos
$query_update = "UPDATE usuarios SET contraseña = ? WHERE id_usuario = ?";
$stmt_update = mysqli_prepare($conexion_metadocs, $query_update);

if (!$stmt_update) {
    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta UPDATE.']);
    exit;
}

mysqli_stmt_bind_param($stmt_update, 'si', $nueva_hash, $id);
mysqli_stmt_execute($stmt_update);

if (mysqli_stmt_errno($stmt_update)) {
    echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar la actualización.']);
    exit;
}

if (mysqli_stmt_affected_rows($stmt_update) > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Contraseña actualizada con éxito.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar la contraseña.']);
}

// Cierre de recursos (opcional pero recomendado)
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmt_update);
mysqli_close($conexion_metadocs);
