<?php

require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';

$correo_usuario = $usuario["correo"]

$sentencia = "SELECT usuarios.nombres, usuarios.correo, usuarios.rol, usuarios.telefono, area_acceso.nombre AS area FROM usuarios JOIN area_acceso ON usuarios.id_area = area_acceso.id_area WHERE correo = $correo_usuario;
$resultado = $conexion_metadocs->query($sentencia);


$conexion_metadocs->close();
?>