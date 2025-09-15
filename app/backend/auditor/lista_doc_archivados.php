<?php
require_once '../../helpers/conexion_bd.php';


$cantidad_tabla = 10;

$pagina = isset($_GET['pagina']) ? filter_var($_GET['pagina'], FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]])  : 1;


$inicio = ($pagina - 1) * $cantidad_tabla;


$sql_paginacion = "SELECT 
            documentos.titulo,
            retencion.categoria,
            documentos.tipo,
            documentos.fin_retencion
        FROM 
            documentos
        JOIN 
            retencion ON documentos.id_retencion = retencion.id_retencion
        WHERE 
            documentos.estado_retencion = 'archivado'
        LIMIT ?, ?";

$stmt = $conexion_metadocs->prepare($sql_paginacion);
$stmt->bind_param("ii", $inicio, $cantidad_tabla);
$stmt->execute();
$resultado = $stmt->get_result();

$documentos_archivados = [];
if ($resultado && $resultado->num_rows > 0) {
    $documentos_archivados = $resultado->fetch_all(MYSQLI_ASSOC);
}


$sql_total = "SELECT COUNT(*) as total FROM documentos WHERE estado_retencion = 'archivado'";
$result_total = $conexion_metadocs->query($sql_total);
$total_filas = $result_total ? (int) $result_total->fetch_assoc()['total'] : 0;


$total_paginas = ceil($total_filas / $cantidad_tabla);

$conexion_metadocs->close();
?>
