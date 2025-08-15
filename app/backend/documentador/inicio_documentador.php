<?php
// dashboard_documentador_data.php - Archivo de datos para requerir (solo lógica de backend)

date_default_timezone_set('America/Bogota');

// Incluir conexión a la base de datos
require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';

$id_usuario = $usuario['id_usuario'];
$id_area = $usuario['id_area'];

// Inicializar variables por defecto

$solicitudes_pendientes_total = 0;
$solicitudes_pendientes_cambio = 0;
$solicitudes_nuevas_hoy = 0;
$documentos_subidos_total = 0;
$documentos_subidos_cambio = 0;
$expedientes_creados_total = 0;
$expedientes_creados_cambio = 0;
$items_aprobados_total = 0;
$items_aprobados_cambio = 0;
$actividad_reciente = [];

try {
    //  Obtener información del usuario
    $query_usuario = "SELECT nombres, apellidos FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion_metadocs, $query_usuario);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $usuario_info = mysqli_fetch_assoc($result);
    
    if ($usuario_info) {
        $usuario_nombre = $usuario_info['nombres'] . ' ' . $usuario_info['apellidos'];
    }

    //  Solicitudes pendientes (activas) dirigidas al documentador
    $query_solicitudes = "SELECT COUNT(*) as total 
                         FROM actividades a
                         INNER JOIN usuarios u ON a.usuario_destinatario = CONCAT(u.nombres, ' ', u.apellidos)
                         WHERE u.id_usuario = ? 
                         AND u.id_area = ?
                         AND a.fecha_visualizacion IS NULL";
    $stmt = mysqli_prepare($conexion_metadocs, $query_solicitudes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_solicitudes = mysqli_fetch_assoc($result);

    if ($result_solicitudes) {
        $solicitudes_pendientes_total = (int)$result_solicitudes['total'];
    }

    //  Solicitudes de la semana pasada para comparar
    $query_solicitudes_semana = "SELECT COUNT(*) as total 
                                FROM actividades a
                                INNER JOIN usuarios u ON a.usuario_destinatario = CONCAT(u.nombres, ' ', u.apellidos)
                                WHERE u.id_usuario = ? 
                                AND u.id_area = ?
                                AND a.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
    $stmt = mysqli_prepare($conexion_metadocs, $query_solicitudes_semana);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_solicitudes_semana = mysqli_fetch_assoc($result);

    if ($result_solicitudes_semana) {
        $solicitudes_pendientes_cambio = (int)$result_solicitudes_semana['total'];
    }

    //  Total de documentos subidos por el documentador
    $query_docs_subidos = "SELECT COUNT(*) as total 
                          FROM documentos 
                          WHERE autor = ? AND id_area = ? AND estado = 'aprobado'";
    $stmt = mysqli_prepare($conexion_metadocs, $query_docs_subidos);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_docs_subidos = mysqli_fetch_assoc($result);

    if ($result_docs_subidos) {
        $documentos_subidos_total = (int)$result_docs_subidos['total'];
    }

    //  Documentos subidos este mes
    $query_docs_mes = "SELECT COUNT(*) as total 
                      FROM documentos 
                      WHERE autor = ? 
                      AND id_area = ?
                      AND MONTH(fecha_creacion) = MONTH(CURDATE()) 
                      AND YEAR(fecha_creacion) = YEAR(CURDATE()) AND estado ='aprobado'";
    $stmt = mysqli_prepare($conexion_metadocs, $query_docs_mes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_docs_mes = mysqli_fetch_assoc($result);

    if ($result_docs_mes) {
        $documentos_subidos_cambio = (int)$result_docs_mes['total'];
    }

    //  Total de expedientes creados por el documentador
    $query_expedientes = "SELECT COUNT(*) as total 
                         FROM expedientes 
                         WHERE autor = ? AND id_area = ? AND estado = 'aprobado'";
    $stmt = mysqli_prepare($conexion_metadocs, $query_expedientes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_expedientes = mysqli_fetch_assoc($result);

    if ($result_expedientes) {
        $expedientes_creados_total = (int)$result_expedientes['total'];
    }

    //  Expedientes creados este mes
    $query_expedientes_mes = "SELECT COUNT(*) as total 
                             FROM expedientes 
                             WHERE autor = ? 
                             AND id_area = ?
                             AND MONTH(fecha_creacion) = MONTH(CURDATE()) 
                             AND YEAR(fecha_creacion) = YEAR(CURDATE()) AND estado ='aprobado'";
    $stmt = mysqli_prepare($conexion_metadocs, $query_expedientes_mes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_expedientes_mes = mysqli_fetch_assoc($result);

    if ($result_expedientes_mes) {
        $expedientes_creados_cambio = (int)$result_expedientes_mes['total'];
    }

    //  Items aprobados (documentos + expedientes aprobados del documentador)
    $query_aprobados = "SELECT 
                        (SELECT COUNT(*) FROM documentos WHERE autor = ? AND id_area = ? AND estado = 'aprobado') +
                        (SELECT COUNT(*) FROM expedientes WHERE autor = ? AND id_area = ? AND estado = 'aprobado') 
                        as total";
    $stmt = mysqli_prepare($conexion_metadocs, $query_aprobados);
    mysqli_stmt_bind_param($stmt, "iiii", $id_usuario, $id_area, $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_aprobados = mysqli_fetch_assoc($result);

    if ($result_aprobados) {
        $items_aprobados_total = (int)$result_aprobados['total'];
    }

    //  Items aprobados este mes
    $query_aprobados_mes = "SELECT 
                           (SELECT COUNT(*) FROM documentos WHERE autor = ? AND id_area = ? AND estado = 'aprobado'
                            AND MONTH(fecha_creacion) = MONTH(CURDATE()) AND YEAR(fecha_creacion) = YEAR(CURDATE())) +
                           (SELECT COUNT(*) FROM expedientes WHERE autor = ? AND id_area = ? AND estado = 'aprobado'
                            AND MONTH(fecha_creacion) = MONTH(CURDATE()) AND YEAR(fecha_creacion) = YEAR(CURDATE()))
                           as total";
    $stmt = mysqli_prepare($conexion_metadocs, $query_aprobados_mes);
    mysqli_stmt_bind_param($stmt, "iiii", $id_usuario, $id_area, $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result_aprobados_mes = mysqli_fetch_assoc($result);

    if ($result_aprobados_mes) {
        $items_aprobados_cambio = (int)$result_aprobados_mes['total'];
    }

    //  Obtener solicitudes nuevas (del día de hoy)
    $query_solicitud_nueva = "SELECT COUNT(*) as totalSolicitudes 
                             FROM actividades a
                             INNER JOIN usuarios u ON a.usuario_destinatario = CONCAT(u.nombres, ' ', u.apellidos)
                             WHERE a.tipo_actividad = 'solicitud_documento' 
                             AND a.fecha_visualizacion IS NULL 
                             AND u.id_usuario = ?
                             AND DATE(a.fecha_creacion) = CURDATE()";
    $stmt_solicitud = mysqli_prepare($conexion_metadocs, $query_solicitud_nueva);
    mysqli_stmt_bind_param($stmt_solicitud, "i", $id_usuario);
    mysqli_stmt_execute($stmt_solicitud);
    $resultado_solicitud = mysqli_stmt_get_result($stmt_solicitud);
    $result_solicitudes_nuevas = mysqli_fetch_assoc($resultado_solicitud);

    if ($result_solicitudes_nuevas) {
        $solicitudes_nuevas_hoy = (int)$result_solicitudes_nuevas['totalSolicitudes'];
    }

    //  Obtener actividad reciente del documentador
    $query_actividad = "SELECT 
                           pa.accion,
                           pa.fecha_accion,
                           pa.entidad,
                           CASE 
                               WHEN pa.entidad = 'documento' THEN d.titulo
                               WHEN pa.entidad = 'expediente' THEN e.nombre
                               ELSE 'Desconocido'
                           END as nombre_entidad
                       FROM pista_auditoria pa
                       LEFT JOIN documentos d ON pa.entidad = 'documento' AND pa.entidad_id = d.id_documento
                       LEFT JOIN expedientes e ON pa.entidad = 'expediente' AND pa.entidad_id = e.id_expediente
                       WHERE pa.id_usuario = ? 
                       AND pa.id_area = ?
                       AND pa.rol = 'documentador'
                       ORDER BY pa.fecha_accion DESC
                       LIMIT 5";
    $stmt = mysqli_prepare($conexion_metadocs, $query_actividad);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $tiempo_transcurrido = obtenerTiempoTranscurrido($row['fecha_accion']);
        
        $actividad_reciente[] = [
            'accion' => $row['accion'],
            'entidad' => $row['entidad'],
            'nombre_entidad' => $row['nombre_entidad'],
            'tiempo' => $tiempo_transcurrido,
            'fecha_accion' => $row['fecha_accion']
        ];
    }

} catch (Exception $e) {
    error_log('Error en dashboard_documentador_data.php: ' . $e->getMessage());
    // Los datos por defecto ya están establecidos al inicio
}

// Función auxiliar para calcular tiempo transcurrido
function obtenerTiempoTranscurrido($fecha) {
    $ahora = new DateTime();
    $fecha_accion = new DateTime($fecha);
    $diferencia = $ahora->diff($fecha_accion);
    
    if ($diferencia->days > 0) {
        if ($diferencia->days == 1) {
            return "Ayer";
        } elseif ($diferencia->days < 7) {
            return "Hace " . $diferencia->days . " días";
        } else {
            return "Hace " . floor($diferencia->days / 7) . " semanas";
        }
    } elseif ($diferencia->h > 0) {
        return "Hace " . $diferencia->h . " horas";
    } elseif ($diferencia->i > 0) {
        return "Hace " . $diferencia->i . " minutos";
    } else {
        return "Hace unos momentos";
    }
}

mysqli_close($conexion_metadocs);
?>