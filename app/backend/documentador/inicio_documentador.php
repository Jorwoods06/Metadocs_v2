<?php

// dashboard_documentador.php - Backend para obtener datos del dashboard del documentador

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

date_default_timezone_set('America/Bogota');

// Incluir conexión a la base de datos
require_once '../../helpers/conexio_graficas.php';
require_once '../../helpers/info_usuario.php';

$id_usuario = $usuario['id_usuario'];
$id_area = $usuario['id_area'];

try {
    $response = [];

    // 1. Obtener información del usuario
    $query_usuario = "SELECT nombres, apellidos FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conn, $query_usuario);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $usuario_info = mysqli_fetch_assoc($result);
    
    $response['usuario'] = [
        'nombre_completo' => $usuario_info['nombres'] . ' ' . $usuario_info['apellidos']
    ];

    // 2. Obtener estadísticas del dashboard

    // Solicitudes pendientes (activas) dirigidas al documentador
    $query_solicitudes = "SELECT COUNT(*) as total 
                         FROM actividades a
                         INNER JOIN usuarios u ON a.usuario_destinatario = CONCAT(u.nombres, ' ', u.apellidos)
                         WHERE u.id_usuario = ? 
                         AND u.id_area = ?
                         AND a.tipo_actividad = 'solicitud_documento'
                         AND a.fecha_visualizacion IS NULL";
    $stmt = mysqli_prepare($conn, $query_solicitudes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $solicitudes_pendientes = mysqli_fetch_assoc($result);

    // Solicitudes de la semana pasada para comparar
    $query_solicitudes_semana = "SELECT COUNT(*) as total 
                                FROM actividades a
                                INNER JOIN usuarios u ON a.usuario_destinatario = CONCAT(u.nombres, ' ', u.apellidos)
                                WHERE u.id_usuario = ? 
                                AND u.id_area = ?
                                AND a.tipo_actividad = 'solicitud_documento'
                                AND a.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
    $stmt = mysqli_prepare($conn, $query_solicitudes_semana);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $solicitudes_semana = mysqli_fetch_assoc($result);

    // Total de documentos subidos por el documentador
    $query_docs_subidos = "SELECT COUNT(*) as total 
                          FROM documentos 
                          WHERE autor = ? AND id_area = ?";
    $stmt = mysqli_prepare($conn, $query_docs_subidos);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $docs_subidos = mysqli_fetch_assoc($result);

    // Documentos subidos este mes
    $query_docs_mes = "SELECT COUNT(*) as total 
                      FROM documentos 
                      WHERE autor = ? 
                      AND id_area = ?
                      AND MONTH(fecha_creacion) = MONTH(CURDATE()) 
                      AND YEAR(fecha_creacion) = YEAR(CURDATE())";
    $stmt = mysqli_prepare($conn, $query_docs_mes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $docs_mes = mysqli_fetch_assoc($result);

    // Total de expedientes creados por el documentador
    $query_expedientes = "SELECT COUNT(*) as total 
                         FROM expedientes 
                         WHERE autor = ? AND id_area = ?";
    $stmt = mysqli_prepare($conn, $query_expedientes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $expedientes_creados = mysqli_fetch_assoc($result);

    // Expedientes creados este mes
    $query_expedientes_mes = "SELECT COUNT(*) as total 
                             FROM expedientes 
                             WHERE autor = ? 
                             AND id_area = ?
                             AND MONTH(fecha_creacion) = MONTH(CURDATE()) 
                             AND YEAR(fecha_creacion) = YEAR(CURDATE())";
    $stmt = mysqli_prepare($conn, $query_expedientes_mes);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $expedientes_mes = mysqli_fetch_assoc($result);

    // Items aprobados (documentos + expedientes aprobados del documentador)
    $query_aprobados = "SELECT 
                        (SELECT COUNT(*) FROM documentos WHERE autor = ? AND id_area = ? AND estado = 'aprobado') +
                        (SELECT COUNT(*) FROM expedientes WHERE autor = ? AND id_area = ? AND estado = 'aprobado') 
                        as total";
    $stmt = mysqli_prepare($conn, $query_aprobados);
    mysqli_stmt_bind_param($stmt, "iiii", $id_usuario, $id_area, $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $items_aprobados = mysqli_fetch_assoc($result);

    // Items aprobados este mes
    $query_aprobados_mes = "SELECT 
                           (SELECT COUNT(*) FROM documentos WHERE autor = ? AND id_area = ? AND estado = 'aprobado'
                            AND MONTH(fecha_creacion) = MONTH(CURDATE()) AND YEAR(fecha_creacion) = YEAR(CURDATE())) +
                           (SELECT COUNT(*) FROM expedientes WHERE autor = ? AND id_area = ? AND estado = 'aprobado'
                            AND MONTH(fecha_creacion) = MONTH(CURDATE()) AND YEAR(fecha_creacion) = YEAR(CURDATE()))
                           as total";
    $stmt = mysqli_prepare($conn, $query_aprobados_mes);
    mysqli_stmt_bind_param($stmt, "iiii", $id_usuario, $id_area, $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $aprobados_mes = mysqli_fetch_assoc($result);



    // obtener solicitudes nuevas 

    $query_solicitud_nueva = "SELECT COUNT(*) as totalSolicitudes 
FROM actividades a
INNER JOIN usuarios u ON a.usuario_destinatario = CONCAT(u.nombres, ' ', u.apellidos)
WHERE a.tipo_actividad = 'solicitud_documento' 
AND a.fecha_visualizacion IS NULL 
AND u.id_usuario = ?
AND DATE(a.fecha_creacion) = CURDATE()";

    $stmt_solicitud = mysqli_prepare($conn, $query_solicitud_nueva);
    mysqli_stmt_bind_param($stmt_solicitud, "i", $id_usuario);
    mysqli_stmt_execute($stmt_solicitud);
    $resultado_solicitud = mysqli_stmt_get_result($stmt_solicitud);
    $ver_solicitudes = mysqli_fetch_assoc($resultado_solicitud);

    // 3. Obtener actividad reciente del documentador
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
    $stmt = mysqli_prepare($conn, $query_actividad);
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

    // 4. Construir la respuesta final
   // 4. Construir la respuesta final
    $response['estadisticas'] = [
        'solicitudes_pendientes' => [
            'total' => (int)$solicitudes_pendientes['total'],
            'cambio_semanal' => (int)$solicitudes_semana['total']
        ],
        'ver_solicitudes' => [
            'totalSolicitudes' => (int)$ver_solicitudes['totalSolicitudes']
        ],
        'documentos_subidos' => [
            'total' => (int)$docs_subidos['total'],
            'cambio_mensual' => (int)$docs_mes['total']
        ],
        'expedientes_creados' => [
            'total' => (int)$expedientes_creados['total'],
            'cambio_mensual' => (int)$expedientes_mes['total']
        ],
        'items_aprobados' => [
            'total' => (int)$items_aprobados['total'],
            'cambio_mensual' => (int)$aprobados_mes['total']
        ]
    ];

    $response['actividad_reciente'] = $actividad_reciente;
    $response['success'] = true;

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => 'Error al obtener los datos del dashboard: ' . $e->getMessage()
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
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

mysqli_close($conn);
?>