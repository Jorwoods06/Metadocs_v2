<?php

require_once '../../helpers/conexion_bd.php';

$sentencia = "SELECT usuarios.nombres, usuarios.correo, usuarios.rol, area_acceso.nombre AS area FROM usuarios JOIN area_acceso ON usuarios.id_area = area_acceso.id_area WHERE correo = 'activo';";
$res_correo = ["correo"]
$resultado = $conexion_metadocs->query($sentencia);


$conexion_metadocs->close();

?>