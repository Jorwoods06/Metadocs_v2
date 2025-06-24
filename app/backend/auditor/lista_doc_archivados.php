<?php
require_once '../../helpers/conexion_bd.php';

$sql = "SELECT 
            documentos.titulo,
            retencion.categoria,
            documentos.tipo,
            documentos.fin_retencion
        FROM 
            documentos
        JOIN 
            retencion ON documentos.id_retencion = retencion.id_retencion
        WHERE 
            documentos.estado_retencion = 'archivado'";

$resultado = $conexion_metadocs->query($sql);

$documentos_archivados = [];
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $documentos_archivados[] = $fila;
    }
}

$conexion_metadocs->close();
?>