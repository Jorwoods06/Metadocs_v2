<?php
// ===== PASO 1: CONFIGURACIÓN DE BASE DE DATOS =====
require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/verificacion_roles.php';
require_once '../../helpers/info_usuario.php';

AutorizacionRol('documentador');

// ===== PASO 2: FUNCIÓN PARA OBTENER NOTIFICACIONES =====
function obtenerNotificaciones($usuario_destinatario) {
    global $conexion_metadocs;
    
    $sql = "SELECT 
    id_actividad,
    id_usuario,
    fecha_visualizacion,
    fecha_creacion,
    tipo_actividad,
    mensaje,
    usuario_destinatario
FROM actividades 
WHERE usuario_destinatario = ?
ORDER BY fecha_creacion DESC;
";
    
    $stmt = $conexion_metadocs->prepare($sql);
    $stmt->bind_param("s", $usuario_destinatario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $notificaciones = [];
    while ($row = $resultado->fetch_assoc()) {
        $notificaciones[] = $row;
    }
    
    return $notificaciones;
}

// ===== PASO 3: FUNCIÓN PARA PROCESAR DATOS DEL MENSAJE =====
function procesarMensaje($mensaje_json) {
    $datos = json_decode($mensaje_json, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'texto' => $mensaje_json,
            'titulo_documento' => '',
            'titulo_expediente' => '',
            'categoria' => '',
            'expediente_destino' => '',
            'motivo' => ''
        ];
    }
    
    return [
        'texto' => $datos['descripcion'] ?? $datos['texto'] ?? '', // ← CAMBIO AQUÍ
        'titulo_documento' => $datos['titulo_documento'] ?? '',
        'titulo_expediente' => $datos['titulo_expediente'] ?? '',
        'categoria' => $datos['categoria'] ?? '',
        'expediente_destino' => $datos['expediente_destinado'] ?? $datos['expediente_destino'] ?? '', // ← CAMBIO AQUÍ
        'motivo' => $datos['motivo'] ?? ''
    ];
}

// ===== PASO 4: FUNCIÓN PARA MAPEAR TIPOS A ICONOS Y ESTILOS =====
function obtenerConfiguracionTipo($tipo_actividad) {
    $configuraciones = [
        'solicitud_documento' => [
            'icono' => 'bi-file-earmark-arrow-up',
            'texto_tipo' => 'Solicitud de documento',
            'clase_css' => 'documento',
            'modal' => 'modal-solicitud-documento'
        ],
        'documento_aprobado' => [
            'icono' => 'bi-file-earmark-check',
            'texto_tipo' => 'Documento aprobado',
            'clase_css' => 'documento-aprobado',
            'modal' => 'modal-documento-aprobado'
        ],
        'documento_rechazado' => [
            'icono' => 'bi-file-earmark-x',
            'texto_tipo' => 'Documento rechazado',
            'clase_css' => 'documento-rechazado',
            'modal' => 'modal-documento-rechazado'
        ],
        'expediente_aprobado' => [
            'icono' => 'bi-folder-check',
            'texto_tipo' => 'Expediente aprobado',
            'clase_css' => 'expediente-aprobado',
            'modal' => 'modal-expediente-aprobado'
        ],
        'expediente_rechazado' => [
            'icono' => 'bi-folder-x',
            'texto_tipo' => 'Expediente rechazado',
            'clase_css' => 'expediente-rechazado',
            'modal' => 'modal-expediente-rechazado'
        ]
    ];
    
    return $configuraciones[$tipo_actividad] ?? [
        'icono' => 'bi-info-circle',
        'texto_tipo' => 'Notificación',
        'clase_css' => 'default',
        'modal' => 'modal-default'
    ];
}

// ===== PASO 5: FUNCIÓN PARA CALCULAR TIEMPO TRANSCURRIDO =====
function tiempoTranscurrido($fecha_creacion) {
    $fecha_actual = new DateTime();
    $fecha_mensaje = new DateTime($fecha_creacion);
    $diferencia = $fecha_actual->diff($fecha_mensaje);
    
    if ($diferencia->days > 0) {
        return "hace " . $diferencia->days . "d";
    } elseif ($diferencia->h > 0) {
        return "hace " . $diferencia->h . "h";
    } elseif ($diferencia->i > 0) {
        return "hace " . $diferencia->i . "m";
    } else {
        return "hace unos segundos";
    }
}

// ===== PASO 6: OBTENER DATOS PARA LA VISTA =====
$usuario_actual = $usuario['nombres']. " ".$usuario['apellidos'] ?? 'metadocs prueba'; // Ajustar según tu 
$notificaciones = obtenerNotificaciones($usuario_actual);

// ===== PASO 7: PROCESAR NOTIFICACIONES PARA LA VISTA =====
$notificaciones_procesadas = [];
foreach ($notificaciones as $notificacion) {
    $datos_mensaje = procesarMensaje($notificacion['mensaje']);
    $config_tipo = obtenerConfiguracionTipo($notificacion['tipo_actividad']);
    
    $notificaciones_procesadas[] = [
        'id' => $notificacion['id_actividad'],
        'usuario_nombre' => obtenerNombreUsuario($notificacion['id_usuario']), // Función a implementar
        'tipo_actividad' => $notificacion['tipo_actividad'],
        'icono' => $config_tipo['icono'],
        'texto_tipo' => $config_tipo['texto_tipo'],
        'clase_css' => $config_tipo['clase_css'],
        'modal' => $config_tipo['modal'],
        'es_visto' => !is_null($notificacion['fecha_visualizacion']),
        'tiempo_transcurrido' => tiempoTranscurrido($notificacion['fecha_creacion']),
        'fecha_creacion' => $notificacion['fecha_creacion'],
        'datos' => $datos_mensaje
    ];
}

// ===== PASO 8: FUNCIÓN AUXILIAR PARA OBTENER NOMBRE DE USUARIO =====
function obtenerNombreUsuario($id_usuario) {
    global $conexion_metadocs;
    
    $sql = "SELECT nombres, apellidos FROM usuarios WHERE id_usuario = ?";
    $stmt = $conexion_metadocs->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($row = $resultado->fetch_assoc()) {
        return trim($row['nombres'] . ' ' . $row['apellidos']);
    }
    
    return 'Usuario Desconocido';
}

// ===== PASO 9: FUNCIÓN PARA MARCAR COMO VISTO =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_visto'])) {
    $id_actividad = $_POST['id_actividad'];
    
    $sql = "UPDATE actividades SET fecha_visualizacion = NOW() WHERE id_actividad = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_actividad);
    $stmt->execute();
    
    echo json_encode(['success' => true]);
    exit;
}
?>