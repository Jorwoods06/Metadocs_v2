<?php
session_start(); 
require_once '../../helpers/conexion_bd.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo "Tu petición ha sido rechazada.";
    exit;
}else{

    $correo  = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $token = $_POST['token'];
    $contraseña_cambio = md5($_POST['conf_contrasena']);

    $sentencia = $conexion_metadocs->prepare("SELECT id_usuario FROM contraseña_resets WHERE token = ? AND expira_en > NOW()");
    $sentencia->bind_param("s", $token);
    $sentencia->execute();
    $resultado = $sentencia->get_result();

    if($resultado->num_rows == 0){
        echo "Token inválido o expirado.";
    } else {
        $sentencia_contraseña = $conexion_metadocs->prepare("UPDATE usuarios SET contraseña = ? WHERE correo = ?");
        $sentencia_contraseña->bind_param("ss", $contraseña_cambio, $correo);
        $sentencia_contraseña->execute();

        $sentencia_contraseña = $conexion_metadocs->prepare("DELETE FROM contraseña_resets WHERE token = ?");
        $sentencia_contraseña->bind_param("s", $token);
        $sentencia_contraseña->execute();

        // Aquí mostramos el HTML de éxito:
      
        exit();
    }   
}
