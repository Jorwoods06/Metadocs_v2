<?php
// dashboard_data_include.php - Backend para incluir datos del dashboard del auditor

date_default_timezone_set('America/Bogota');


require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';

$id_usuario = $usuario['id_usuario'];
$id_area = $usuario['id_area'];
$usuario_nombre = $usuario['nombres'];
$usuario_apellido = $usuario['apellidos'];

try {



    $nombre_completo = $usuario_nombre . ' ' . $usuario_apellido;


    $query_pendientes = "SELECT 
        (SELECT COUNT(*) 
        FROM documentos d
        INNER JOIN expedientes e ON d.id_expediente = e.id_expediente
        WHERE d.id_area = ? AND d.estado = 'revision') 
        +
        (SELECT COUNT(*)
        FROM expedientes c
        INNER JOIN expedientes e ON c.id_expediente = e.id_expediente
        WHERE c.id_area = ? AND c.estado = 'revision') AS total;";
    $stmt = mysqli_prepare($conexion_metadocs, $query_pendientes);
    mysqli_stmt_bind_param($stmt, "ii", $id_area, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pendientes = mysqli_fetch_assoc($result);
    $documentos_pendientes_total = (int)$pendientes['total'];

    // Documentos pendientes de la semana pasada para comparar
    $query_pendientes_semana = "SELECT (SELECT COUNT(*) FROM documentos d INNER JOIN expedientes e ON d.id_expediente = e.id_expediente WHERE d.id_area = ? AND d.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)) + (SELECT COUNT(*) FROM expedientes e WHERE e.id_area = ? AND e.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)) AS total;";
    $stmt = mysqli_prepare($conexion_metadocs, $query_pendientes_semana);
    mysqli_stmt_bind_param($stmt, "ii", $id_area, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pendientes_semana = mysqli_fetch_assoc($result);
    $documentos_pendientes_cambio = (int)$pendientes_semana['total'];

    // Total de documentos del área

    $query_total_docs = "SELECT COUNT(*) as total FROM documentos d 
                        INNER JOIN expedientes e ON d.id_expediente = e.id_expediente 
                        WHERE d.id_area = ? AND d.estado = 'aprobado'";
    $stmt = mysqli_prepare($conexion_metadocs, $query_total_docs);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $total_docs = mysqli_fetch_assoc($result);
    $total_documentos = (int)$total_docs['total'];

    // Documentos del mes pasado para comparar (solo aprobados)
    $query_docs_mes = "SELECT COUNT(*) as total FROM documentos d 
                      INNER JOIN expedientes e ON d.id_expediente = e.id_expediente 
                      WHERE d.id_area = ? 
                      AND d.estado = 'aprobado'
                      AND d.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    $stmt = mysqli_prepare($conexion_metadocs, $query_docs_mes);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $docs_mes = mysqli_fetch_assoc($result);
    $total_documentos_cambio = (int)$docs_mes['total'];

    // Expedientes activos (aprobados) del área
    $query_expedientes = "SELECT COUNT(*) as total FROM expedientes 
                         WHERE estado = 'aprobado' AND id_area = ?";
    $stmt = mysqli_prepare($conexion_metadocs, $query_expedientes);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $expedientes_activos = mysqli_fetch_assoc($result);
    $expedientes_activos_total = (int)$expedientes_activos['total'];

    // Total expedientes en el mes
    $query_total_expedientes = "SELECT COUNT(*) AS total FROM expedientes WHERE estado = 'aprobado' AND MONTH(fecha_creacion) = MONTH(CURDATE()) AND YEAR(fecha_creacion) = YEAR(CURDATE()) AND id_area = ?;";
    $stmt = mysqli_prepare($conexion_metadocs, $query_total_expedientes);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $expedientes_activos_mes = mysqli_fetch_assoc($result);
    $expedientes_activos_cambio = (int)$expedientes_activos_mes['total'];

    // Acciones realizadas por el auditor en el mes actual
    $query_acciones = "SELECT COUNT(*) as total 
                    FROM pista_auditoria 
                    WHERE id_usuario = ? 
                        AND id_area = ? 
                        AND MONTH(fecha_accion) = MONTH(CURDATE()) 
                        AND YEAR(fecha_accion) = YEAR(CURDATE())";
    $stmt = mysqli_prepare($conexion_metadocs, $query_acciones);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $acciones_total = mysqli_fetch_assoc($result);
    $acciones_realizadas_total = (int)$acciones_total['total'];

    // Acciones de hoy
    $query_acciones_hoy = "SELECT COUNT(*) as total FROM pista_auditoria 
                          WHERE id_usuario = ? AND id_area = ? 
                          AND DATE(fecha_accion) = CURDATE()";
    $stmt = mysqli_prepare($conexion_metadocs, $query_acciones_hoy);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $acciones_hoy = mysqli_fetch_assoc($result);
    $acciones_realizadas_cambio = (int)$acciones_hoy['total'];

    // Obtener actividad reciente del auditor
    $query_actividad = "SELECT pa.accion, pa.fecha_accion, pa.entidad, pa.entidad_id,
        CASE 
            WHEN pa.entidad = 'documento' AND d.titulo IS NOT NULL THEN d.titulo
            WHEN pa.entidad = 'documento' AND d.titulo IS NULL THEN 'Documento solicitado'
            WHEN pa.entidad = 'expediente' AND e.nombre IS NOT NULL THEN e.nombre
            ELSE CONCAT('ID: ', pa.entidad_id)
        END AS nombre_entidad,
        CASE
            WHEN pa.accion = 'aprobó' THEN 'approved'
            WHEN pa.accion = 'rechazó' THEN 'rejected'
            WHEN pa.accion = 'solicitó' THEN 'requested'
            ELSE 'pending'
        END AS tipo_accion,
        CASE 
            WHEN pa.accion = 'aprobó' AND pa.entidad = 'documento' THEN 'aprobado'
            WHEN pa.accion = 'aprobó' AND pa.entidad = 'expediente' THEN 'aprobado'
            WHEN pa.accion = 'rechazó' AND pa.entidad = 'documento' THEN 'rechazado'
            WHEN pa.accion = 'rechazó' AND pa.entidad = 'expediente' THEN 'rechazado'
            WHEN pa.accion = 'solicitó' AND pa.entidad = 'documento' THEN 'solicitaste'
            ELSE pa.accion
        END AS accion_corregida
    FROM pista_auditoria pa
    LEFT JOIN documentos d ON pa.entidad = 'documento' AND pa.entidad_id = d.id_documento
    LEFT JOIN expedientes e ON pa.entidad = 'expediente' AND pa.entidad_id = e.id_expediente
    WHERE pa.id_usuario = ? AND pa.id_area = ?
    ORDER BY pa.fecha_accion DESC
    LIMIT 5";

    $stmt = mysqli_prepare($conexion_metadocs, $query_actividad);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $actividades_recientes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        
        $fecha_actividad = new DateTime($row['fecha_accion']);
        $ahora = new DateTime();
        $diff = $ahora->diff($fecha_actividad);

        if ($diff->d > 0) {
            $tiempo = $diff->d == 1 ? 'Ayer' : 'Hace ' . $diff->d . ' días';
        } elseif ($diff->h > 0) {
            $tiempo = 'Hace ' . $diff->h . ' hora' . ($diff->h > 1 ? 's' : '');
        } elseif ($diff->i > 0) {
            $tiempo = 'Hace ' . $diff->i . ' minuto' . ($diff->i > 1 ? 's' : '');
        } else {
            $tiempo = 'Hace un momento';
        }

        $actividades_recientes[] = [
            'accion' => $row['accion_corregida'],
            'entidad' => $row['entidad'],
            'nombre_entidad' => $row['nombre_entidad'],
            'tipo_accion' => $row['tipo_accion'],
            'tiempo' => $tiempo,
            'fecha' => $row['fecha_accion']
        ];
    }
} catch (Exception $e) {
    // En caso de error, establecer valores por defecto
    $nombre_completo = 'Usuario';
    $documentos_pendientes_total = 0;
    $documentos_pendientes_cambio = 0;
    $total_documentos = 0;
    $total_documentos_cambio = 0;
    $expedientes_activos_total = 0;
    $expedientes_activos_cambio = 0;
    $acciones_realizadas_total = 0;
    $acciones_realizadas_cambio = 0;
    $actividades_recientes = [];

    error_log('Error en dashboard_data_include.php: ' . $e->getMessage());
}


function obtenerClaseIcono($tipo_accion)
{
    $clases = [
        'approved' => 'icon-approved',
        'rejected' => 'icon-rejected',
        'requested' => 'icon-request',
        'pending' => 'icon-clock'
    ];
    return $clases[$tipo_accion] ?? 'icon-clock';
}


function obtenerIconoFontAwesome($tipo_accion)
{
    $iconos = [
        'approved' => 'fas fa-check-circle',
        'rejected' => 'fas fa-times-circle',
        'requested' => 'fas fa-file-circle-plus',
        'pending' => 'fas fa-clock'
    ];
    return $iconos[$tipo_accion] ?? 'fas fa-clock';
}


function generarTextoActividad($actividad)
{
    $entidad_tipo = $actividad['entidad'] === 'documento' ? 'Documento' : 'Expediente';

    if ($actividad['accion'] === 'solicitaste' && $actividad['entidad'] === 'documento') {
        return 'Solicitaste documento';
    }

    return $entidad_tipo . ' "' . $actividad['nombre_entidad'] . '" ' . $actividad['accion'];
}

mysqli_close($conexion_metadocs);
