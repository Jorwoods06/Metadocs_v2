<?php
date_default_timezone_set('America/Bogota');

require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/info_usuario.php';

$id_usuario = $usuario['id_usuario'];
$id_area = $usuario['id_area'];
$nombre_usuario = $usuario['nombres'];
$apellido_usuario = $usuario['apellidos'];

$usuario_nombre = $nombre_usuario . ' ' . $apellido_usuario;

// Solicitudes pendientes
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
$solicitudes_pendientes_total = $result_solicitudes ? (int)$result_solicitudes['total'] : 0;

// Solicitudes de la semana
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
$solicitudes_pendientes_cambio = $result_solicitudes_semana ? (int)$result_solicitudes_semana['total'] : 0;

// Documentos subidos
$query_docs_subidos = "SELECT COUNT(*) as total 
                      FROM documentos 
                      WHERE autor = ? AND id_area = ? AND estado = 'aprobado'";
$stmt = mysqli_prepare($conexion_metadocs, $query_docs_subidos);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result_docs_subidos = mysqli_fetch_assoc($result);
$documentos_subidos_total = $result_docs_subidos ? (int)$result_docs_subidos['total'] : 0;

// Documentos subidos este mes
$query_docs_mes = "SELECT COUNT(*) as total 
                  FROM documentos 
                  WHERE autor = ? 
                  AND id_area = ?
                  AND MONTH(fecha_creacion) = MONTH(CURDATE()) 
                  AND YEAR(fecha_creacion) = YEAR(CURDATE()) 
                  AND estado ='aprobado'";
$stmt = mysqli_prepare($conexion_metadocs, $query_docs_mes);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result_docs_mes = mysqli_fetch_assoc($result);
$documentos_subidos_cambio = $result_docs_mes ? (int)$result_docs_mes['total'] : 0;

// Expedientes creados
$query_expedientes = "SELECT COUNT(*) as total 
                     FROM expedientes 
                     WHERE autor = ? AND id_area = ? AND estado = 'aprobado'";
$stmt = mysqli_prepare($conexion_metadocs, $query_expedientes);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result_expedientes = mysqli_fetch_assoc($result);
$expedientes_creados_total = $result_expedientes ? (int)$result_expedientes['total'] : 0;

// Expedientes creados este mes
$query_expedientes_mes = "SELECT COUNT(*) as total 
                         FROM expedientes 
                         WHERE autor = ? 
                         AND id_area = ?
                         AND MONTH(fecha_creacion) = MONTH(CURDATE()) 
                         AND YEAR(fecha_creacion) = YEAR(CURDATE()) 
                         AND estado ='aprobado'";
$stmt = mysqli_prepare($conexion_metadocs, $query_expedientes_mes);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result_expedientes_mes = mysqli_fetch_assoc($result);
$expedientes_creados_cambio = $result_expedientes_mes ? (int)$result_expedientes_mes['total'] : 0;

// Items aprobados
$query_aprobados = "SELECT 
                    (SELECT COUNT(*) FROM documentos WHERE autor = ? AND id_area = ? AND estado = 'aprobado') +
                    (SELECT COUNT(*) FROM expedientes WHERE autor = ? AND id_area = ? AND estado = 'aprobado') 
                    as total";
$stmt = mysqli_prepare($conexion_metadocs, $query_aprobados);
mysqli_stmt_bind_param($stmt, "iiii", $id_usuario, $id_area, $id_usuario, $id_area);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$result_aprobados = mysqli_fetch_assoc($result);
$items_aprobados_total = $result_aprobados ? (int)$result_aprobados['total'] : 0;

// Items aprobados este mes
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
$items_aprobados_cambio = $result_aprobados_mes ? (int)$result_aprobados_mes['total'] : 0;

// Solicitudes nuevas hoy
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
$solicitudes_nuevas_hoy = $result_solicitudes_nuevas ? (int)$result_solicitudes_nuevas['totalSolicitudes'] : 0;

// Actividad reciente
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

$actividad_reciente = [];
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
