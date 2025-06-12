<?php
require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';


$area = $usuario['id_area'];






// funcion subir expediente

function subirExpediente($conexion, $nombre, $descripcion, $padreId, $area){
    $estado = 'revision';
    $sql_expediente = $conexion->prepare("INSERT INTO expedientes (nombre, descripcion, expediente_padre, id_area, estado) VALUES (?,?,?,?,?)");

    if ($sql_expediente) {
        $sql_expediente->bind_param("ssiis", $nombre, $descripcion, $padreId, $area, $estado); 
        return $sql_expediente->execute();
    } else {
        die("Error al preparar la consulta: " . $conexion->error);
    }
}




//manejo de los datos de las modales 


if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo "tu peticion ha sido rechazada";
} else {
    switch($_POST['accion']){
        case 'subir_expediente':
            $nombre = $_POST['titulo_carpeta']; 
            $descripcion = $_POST['desc_carpeta']; 
            $padreId = $_POST['expediente_padre'] ?? 0;
            
            if (subirExpediente($conexion_metadocs, $nombre, $descripcion, $padreId, $area)) {
                header("Location: ../../vistas/documentador/ver_documentos.php");
            } else {
                header("Location: ../../vistas/documentador/ver_documentos.php");
                echo 'error';
            }
            break;
    }
}
?>