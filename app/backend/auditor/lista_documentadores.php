<?php  
require_once '../../helpers/conexion_bd.php'; 
require_once '../../helpers/info_usuario.php';  

$area_usuarios = $usuario['id_area'];  

$sql_lista_documentadores = "SELECT id_usuario, nombres, apellidos FROM `usuarios` WHERE usuarios.rol = 'documentador' AND usuarios.id_area = ? AND usuarios.estado = 'activo'"; 

$stmt = $conexion_metadocs->prepare($sql_lista_documentadores);
$stmt->bind_param("i", $area_usuarios);
$stmt->execute();
$resultado = $stmt->get_result();

$datos_documentadores = [];

if ($resultado->num_rows > 0) {     
    while ($row = $resultado->fetch_assoc()) {         
        $datos_documentadores[] = [
            'id' => $row['id_usuario'],
            'nombre' => $row['nombres'] . ' ' . $row['apellidos']
        ];
    } 
}

$stmt->close();

// Si es una petición AJAX, devolver JSON
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'documentadores' => $datos_documentadores
    ]);
    exit;
}
?>