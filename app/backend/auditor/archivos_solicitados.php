<?php

require_once '../../helpers/conexion_bd.php';

$sentencia_expediente = "SELECT id_expediente, nombre, descripcion, nombres AS nombre_autor, expedientes.fecha_creacion FROM `expedientes` JOIN usuarios ON expedientes.autor = usuarios.id_usuario WHERE expedientes.estado = 'revision';";

$resultado_expediente = $conexion_metadocs->query($sentencia_expediente);



?>