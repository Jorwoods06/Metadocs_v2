<?php


// dashboard_data.php - Backend para obtener datos del dashboard del auditor

use Dom\Mysql;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

date_default_timezone_set('America/Bogota');

// Incluir conexión a la base de datos
require_once '../../helpers/conexio_graficas.php';
require_once '../../helpers/info_usuario.php';



$id_usuario = $usuario['id_usuario'];
$id_area =$usuario['id_area'];

try {
    $response = [];

    // 1. Obtener información del usuario
    $query_usuario = "SELECT nombres, apellidos FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conn, $query_usuario);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($result);
    
    $response['usuario'] = [
        'nombre_completo' => $usuario['nombres'] . ' ' . $usuario['apellidos']
    ];

    // 2. Obtener estadísticas del dashboard
    
    // Archivos pendientes (en revisión) del área del auditor
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
    $stmt = mysqli_prepare($conn, $query_pendientes);
    mysqli_stmt_bind_param($stmt, "ii", $id_area,$id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pendientes = mysqli_fetch_assoc($result);

    // Documentos pendientes de la semana pasada para comparar
    $query_pendientes_semana = "SELECT COUNT(*) as total FROM documentos d 
                               INNER JOIN expedientes e ON d.id_expediente = e.id_expediente 
                               WHERE d.estado = 'revision' AND d.id_area = ? 
                               AND d.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
    $stmt = mysqli_prepare($conn, $query_pendientes_semana);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pendientes_semana = mysqli_fetch_assoc($result);

    // Total de documentos del área
    $query_total_docs = "SELECT COUNT(*) as total FROM documentos d 
                        INNER JOIN expedientes e ON d.id_expediente = e.id_expediente 
                        WHERE d.id_area = ?";
    $stmt = mysqli_prepare($conn, $query_total_docs);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $total_docs = mysqli_fetch_assoc($result);

    // Documentos del mes pasado para comparar
    $query_docs_mes = "SELECT COUNT(*) as total FROM documentos d 
                      INNER JOIN expedientes e ON d.id_expediente = e.id_expediente 
                      WHERE d.id_area = ? 
                      AND d.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    $stmt = mysqli_prepare($conn, $query_docs_mes);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $docs_mes = mysqli_fetch_assoc($result);

    // Expedientes activos (aprobados) del área
    $query_expedientes = "SELECT COUNT(*) as total FROM expedientes 
                         WHERE estado = 'aprobado' AND id_area = ?";
    $stmt = mysqli_prepare($conn, $query_expedientes);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $expedientes_activos = mysqli_fetch_assoc($result);

    //toal expedientes en el mes

    $query_total_expedientes = "SELECT COUNT(*) AS total FROM expedientes WHERE estado = 'aprobado' AND MONTH(fecha_creacion) = MONTH(CURDATE()) AND YEAR(fecha_creacion) = YEAR(CURDATE()) AND id_area = ?;";

    $stmt = mysqli_prepare($conn, $query_total_expedientes);
    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $expedientes_activos_mes = mysqli_fetch_assoc($result);


 // Acciones realizadas por el auditor en el mes actual (de la pista de auditoría)
    $query_acciones = "SELECT COUNT(*) as total 
                    FROM pista_auditoria 
                    WHERE id_usuario = ? 
                        AND id_area = ? 
                        AND MONTH(fecha_accion) = MONTH(CURDATE()) 
                        AND YEAR(fecha_accion) = YEAR(CURDATE())";

    $stmt = mysqli_prepare($conn, $query_acciones);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $acciones_total = mysqli_fetch_assoc($result);


    // Acciones de hoy
    $query_acciones_hoy = "SELECT COUNT(*) as total FROM pista_auditoria 
                          WHERE id_usuario = ? AND id_area = ? 
                          AND DATE(fecha_accion) = CURDATE()";
    $stmt = mysqli_prepare($conn, $query_acciones_hoy);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $acciones_hoy = mysqli_fetch_assoc($result);

    $response['estadisticas'] = [
        'documentos_pendientes' => [
            'total' => (int)$pendientes['total'],
            'cambio' => (int)$pendientes_semana['total'],
            'periodo' => 'esta semana'
        ],
        'total_documentos' => [
            'total' => (int)$total_docs['total'],
            'cambio' => (int)$docs_mes['total'],
            'periodo' => 'este mes'
        ],
        'expedientes_activos' => [
            'total' => (int)$expedientes_activos['total'],
            'cambio' => (int)$expedientes_activos_mes['total'],
            'periodo' => 'este mes'
        ],
        'acciones_realizadas' => [
            'total' => (int)$acciones_total['total'],
            'cambio' => (int)$acciones_hoy['total'],
            'periodo' => 'hoy'
        ]
    ];

    // 3. Obtener actividad reciente del auditor
    $query_actividad = $query_actividad = "SELECT pa.accion, pa.fecha_accion, pa.entidad, pa.entidad_id,
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
   -- Generar texto corregido de la actividad
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

    
    $stmt = mysqli_prepare($conn, $query_actividad);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_area);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $actividades = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Calcular tiempo transcurrido
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

        $actividades[] = [
    'accion' => $row['accion_corregida'], // Usar la acción corregida
    'entidad' => $row['entidad'],
    'nombre_entidad' => $row['nombre_entidad'],
    'tipo_accion' => $row['tipo_accion'],
    'tiempo' => $tiempo,
    'fecha' => $row['fecha_accion']
];
    }

    $response['actividad_reciente'] = $actividades;

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>



