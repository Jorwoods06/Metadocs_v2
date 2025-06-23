<?php

require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';


if($_SERVER['REQUEST_METHOD'] != 'POST'){

    echo 'no tienes acceso a esta vista';

}else{

    $categoria = $_POST['tipo'];
    $responsable = $_POST['responsable_display'];
    $expediente = $_POST['expediente_display'];
    $descripcion = $_POST['descripcion'];

    $id_usuario = $usuario['id_usuario'];


       $mensaje_json = json_encode([
        'categoria' => $categoria,
        'expediente_destinado' => $expediente,
        'descripcion' => $descripcion,
        'estado' => 'pendiente'
    ], JSON_UNESCAPED_UNICODE);

    
    $id_usuario_escaped = mysqli_real_escape_string($conexion_metadocs, $id_usuario);
    $tipo_actividad_escaped = mysqli_real_escape_string($conexion_metadocs, 'solicitud_documento');
    $mensaje_escaped = mysqli_real_escape_string($conexion_metadocs, $mensaje_json);

    
  $sql_actividad = "INSERT INTO actividades (id_usuario, tipo_actividad, mensaje, fecha_creacion, usuario_destinatario) 
        VALUES ('$id_usuario_escaped', '$tipo_actividad_escaped', '$mensaje_escaped', NOW(), '$responsable')";


if (mysqli_query($conexion_metadocs, $sql_actividad)) {
      
        $id_solicitud = mysqli_insert_id($conexion_metadocs);
        
       header('Location: ../../vistas/auditor/solicitar_documento.php?msg=solicitud_enviada');
       
      
    } else {
        // Error en la consulta
       header('Location: ../../vistas/auditor/solicitar_documento.php?msg=error_en_la_consulta');
    }
    
    // Cerrar conexión
    mysqli_close($conexion_metadocs);
}








?>