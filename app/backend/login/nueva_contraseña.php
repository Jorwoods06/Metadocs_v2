<?php

require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){

$correo_usuario = $usuario["correo"];
$contra_vieja = $_POST["contraseña"];
$contra_nueva = md5($_POST["nueva_contraseña"]);

$sentencia = "SELECT usuarios.contraseña FROM usuarios WHERE correo = '$correo_usuario'";

$resultado = $conexion_metadocs->query($sentencia);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $contra_nueva = "UPDATE usuarios SET contraseña=$contra_nueva WHERE correo = $correo_usuario";
} else{
    echo("No fue posible actualizar la contraseña");
}
$conexion_metadocs->close();
}
?>