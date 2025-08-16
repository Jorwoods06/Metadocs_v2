<?php
session_start();

require_once '../../helpers/conexion_bd.php';


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "tu peticion ha sido rechazada";
    exit();
}

$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$telefono = filter_input(INPUT_POST, 'telefono', FILTER_VALIDATE_INT);
$cedula = filter_input(INPUT_POST, 'cedula', FILTER_VALIDATE_INT);
$rol = isset($_POST['rol']) ? trim($_POST['rol']) : '';
$area = isset($_POST['area']) ? trim($_POST['area']) : '';
$contrasena = isset($_POST['contrasena']) ? md5(trim($_POST['contrasena'])) : '';


if (empty($nombre) || empty($apellido) || empty($email) || empty($telefono) || empty($contrasena) || empty($cedula) || empty($rol) || empty($area)) {
    $_SESSION['error'] = "Por favor complete todos los campos.";
    header('Location: ../../vistas/admin/creacion_usuario.php');
    exit();
}



$sql_verificar_email = "SELECT correo FROM usuarios WHERE correo = ?";
$sentencia = $conexion_metadocs->prepare($sql_verificar_email);
$sentencia->bind_param("s", $email);
$sentencia->execute();
$resultado = $sentencia->get_result();

if ($resultado->num_rows > 0) {
    $_SESSION['correo_existente'] = "El correo electrónico ya está registrado.";
    header('Location: ../../vistas/admin/creacion_usuario.php');
    exit();
}



$sql_buscar_area = "SELECT id_area FROM area_acceso WHERE nombre = ?";
$sentencia_area = $conexion_metadocs->prepare($sql_buscar_area);
$sentencia_area->bind_param("s", $area);
$sentencia_area->execute();
$resultado_area = $sentencia_area->get_result();

if ($resultado_area->num_rows === 0) {
    $_SESSION['error'] = "El área especificada no existe.";
    header('Location: ../../vistas/admin/creacion_usuario.php');
    exit();
}

$id_area = $resultado_area->fetch_assoc()['id_area'];



$sql_usuario = "INSERT INTO usuarios (nombres, apellidos, correo, contraseña, cedula, telefono, rol, id_area) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
$sentencia_usuario = $conexion_metadocs->prepare($sql_usuario);
$sentencia_usuario->bind_param("sssssssi", $nombre, $apellido, $email, $contrasena, $cedula, $telefono, $rol, $id_area);


if ($sentencia_usuario->execute()) {
    $_SESSION['exito'] = 'Usuario creado con éxito';
    header('Location: ../../vistas/admin/creacion_usuario.php');
    exit();
} else {
    $_SESSION['error'] = "Error al registrar los datos: " . $sentencia_usuario->error;
    header('Location: ../../vistas/admin/creacion_usuario.php?=false');
    exit();
}

$conexion_metadocs->close();
