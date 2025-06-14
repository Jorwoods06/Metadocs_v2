<?php

require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';

$correo_usuario = $usuario["correo"];

$sentencia = "SELECT usuarios.nombres, usuarios.apellidos, usuarios.correo, usuarios.rol, usuarios.cedula, usuarios.telefono, area_acceso.nombre AS area FROM usuarios JOIN area_acceso ON usuarios.id_area = area_acceso.id_area WHERE correo = '$correo_usuario'";

$resultado = $conexion_metadocs->query($sentencia);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    //echo $fila["nombres"] . " - ". $fila["apellidos"] . "-" . $fila["cedula"] . " - " . $fila["telefono"] ." - ". $fila["correo"] ." - " . $fila["rol"] ." - " . $fila["cedula"] ." - " . $fila["area"];
} else {
    echo "No se encontró el usuario.";
}

$conexion_metadocs->close();

?>

