<?php

require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/verificacion_roles.php';
require_once '../../helpers/info_usuario.php';
date_default_timezone_set('America/Bogota');

$pagina_actual = filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1]
]);
$registros_por_pagina = 10; 
$offset = ($pagina_actual - 1) * $registros_por_pagina;


function obtenerNotificaciones($usuario_destinatario, $limit = 10, $offset = 0) {
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
    ORDER BY fecha_creacion DESC
    LIMIT ? OFFSET ?";
    
    $stmt = $conexion_metadocs->prepare($sql);
    $stmt->bind_param("sii", $usuario_destinatario, $limit, $offset);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $notificaciones = [];
    while ($row = $resultado->fetch_assoc()) {
        $notificaciones[] = $row;
    }
    
    return $notificaciones;
}


function contarTotalNotificaciones($usuario_destinatario) {
    global $conexion_metadocs;
    
    $sql = "SELECT COUNT(*) as total FROM actividades WHERE usuario_destinatario = ?";
    $stmt = $conexion_metadocs->prepare($sql);
    $stmt->bind_param("s", $usuario_destinatario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    
    return $row['total'];
}


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
        'texto' => $datos['descripcion'] ?? $datos['texto'] ?? '',
        'titulo_documento' => $datos['titulo_documento'] ?? '',
        'titulo_expediente' => $datos['titulo_expediente'] ?? '',
        'categoria' => $datos['categoria'] ?? '',
        'expediente_destino' => $datos['expediente_destinado'] ?? $datos['expediente_destino'] ?? '',
        'motivo' => $datos['motivo'] ?? ''
    ];
}


function obtenerConfiguracionTipo($tipo_actividad) {
    $configuraciones = [
        'solicitud_documento' => [
            'icono' => 'fa-file-text',
            'texto_tipo' => 'Solicitud de documento',
            'clase_css' => 'documento',
            'modal' => 'modal-solicitud-documento'
        ],
        'documento_aprobado' => [
            'icono' => 'fa-check-circle',
            'texto_tipo' => 'Documento aprobado',
            'clase_css' => 'documento-aprobado',
            'modal' => 'modal-documento-aprobado'
        ],
        'documento_rechazado' => [
            'icono' => 'fa-times-circle',
            'texto_tipo' => 'Documento rechazado',
            'clase_css' => 'documento-rechazado',
            'modal' => 'modal-documento-rechazado'
        ],
        'expediente_aprobado' => [
            'icono' => 'fa-folder-open',
            'texto_tipo' => 'Expediente aprobado',
            'clase_css' => 'expediente-aprobado',
            'modal' => 'modal-expediente-aprobado'
        ],
        'expediente_rechazado' => [
            'icono' => 'fa-folder-minus',
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


date_default_timezone_set('America/Bogota');


function tiempoTranscurrido($fecha_creacion) {
    try {
        
        $timezone = new DateTimeZone('America/Bogota');
        
        $fecha_actual = new DateTime('now', $timezone);
        $fecha_mensaje = new DateTime($fecha_creacion, $timezone);
        
      
        $diferencia = $fecha_actual->diff($fecha_mensaje);
        
        if ($diferencia->days > 30) {
            $meses = floor($diferencia->days / 30);
            return "hace " . $meses . " mes" . ($meses > 1 ? "es" : "");
        } elseif ($diferencia->days > 0) {
            return "hace " . $diferencia->days . " día" . ($diferencia->days > 1 ? "s" : "");
        } elseif ($diferencia->h > 0) {
            return "hace " . $diferencia->h . " hora" . ($diferencia->h > 1 ? "s" : "");
        } elseif ($diferencia->i > 0) {
            return "hace " . $diferencia->i . " minuto" . ($diferencia->i > 1 ? "s" : "");
        } else {
            return "hace unos segundos";
        }
        
    } catch (Exception $e) {
      
        error_log("Error calculando tiempo transcurrido: " . $e->getMessage());
        return "hace un momento";
    }
}


function tiempoTranscurridoSimple($fecha_creacion) {

    date_default_timezone_set('America/Bogota');
    

    $timestamp_mensaje = strtotime($fecha_creacion);
    $timestamp_actual = time();
    
    
    $diferencia_segundos = $timestamp_actual - $timestamp_mensaje;
    
    // Convertir a unidades más grandes
    $minutos = floor($diferencia_segundos / 60);
    $horas = floor($diferencia_segundos / 3600);
    $dias = floor($diferencia_segundos / 86400);
    $meses = floor($diferencia_segundos / 2592000); // 30 días
    
    if ($meses > 0) {
        return "hace " . $meses . " mes" . ($meses > 1 ? "es" : "");
    } elseif ($dias > 0) {
        return "hace " . $dias . " día" . ($dias > 1 ? "s" : "");
    } elseif ($horas > 0) {
        return "hace " . $horas . " hora" . ($horas > 1 ? "s" : "");
    } elseif ($minutos > 0) {
        return "hace " . $minutos . " minuto" . ($minutos > 1 ? "s" : "");
    } else {
        return "hace unos segundos";
    }
}


$usuario_actual = $usuario['nombres']. " ".$usuario['apellidos'] ?? 'metadocs prueba';


$total_registros = contarTotalNotificaciones($usuario_actual);
$total_paginas = ceil($total_registros / $registros_por_pagina);


$notificaciones = obtenerNotificaciones($usuario_actual, $registros_por_pagina, $offset);


$notificaciones_procesadas = [];
foreach ($notificaciones as $notificacion) {
    $datos_mensaje = procesarMensaje($notificacion['mensaje']);
    $config_tipo = obtenerConfiguracionTipo($notificacion['tipo_actividad']);
    
    $notificaciones_procesadas[] = [
        'id' => $notificacion['id_actividad'],
        'usuario_nombre' => obtenerNombreUsuario($notificacion['id_usuario']),
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


function generarPaginacion($pagina_actual, $total_paginas, $url_base = '') {
    if ($total_paginas <= 1) {
        return '';
    }
    
    $html = '<nav aria-label="Paginación de notificaciones">';
    $html .= '<ul class="pagination justify-content-center">';
    
    // Botón anterior
    if ($pagina_actual > 1) {
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . $url_base . '?pagina=' . ($pagina_actual - 1) . '">';
        $html .= '<i class="bi bi-chevron-left"></i> Anterior</a>';
        $html .= '</li>';
    } else {
        $html .= '<li class="page-item disabled">';
        $html .= '<span class="page-link"><i class="bi bi-chevron-left"></i> Anterior</span>';
        $html .= '</li>';
    }
    
    // Páginas numeradas
    $inicio = max(1, $pagina_actual - 2);
    $fin = min($total_paginas, $pagina_actual + 2);
    
    // Primera página si no está en el rango
    if ($inicio > 1) {
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . $url_base . '?pagina=1">1</a>';
        $html .= '</li>';
        if ($inicio > 2) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    // Páginas en el rango
    for ($i = $inicio; $i <= $fin; $i++) {
        if ($i == $pagina_actual) {
            $html .= '<li class="page-item active">';
            $html .= '<span class="page-link">' . $i . '</span>';
            $html .= '</li>';
        } else {
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" href="' . $url_base . '?pagina=' . $i . '">' . $i . '</a>';
            $html .= '</li>';
        }
    }
    
    // Última página si no está en el rango
    if ($fin < $total_paginas) {
        if ($fin < $total_paginas - 1) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . $url_base . '?pagina=' . $total_paginas . '">' . $total_paginas . '</a>';
        $html .= '</li>';
    }
    
    // Botón siguiente
    if ($pagina_actual < $total_paginas) {
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . $url_base . '?pagina=' . ($pagina_actual + 1) . '">';
        $html .= 'Siguiente <i class="bi bi-chevron-right"></i></a>';
        $html .= '</li>';
    } else {
        $html .= '<li class="page-item disabled">';
        $html .= '<span class="page-link">Siguiente <i class="bi bi-chevron-right"></i></span>';
        $html .= '</li>';
    }
    
    $html .= '</ul>';
    $html .= '</nav>';
    
    return $html;
}


$inicio_registro = ($pagina_actual - 1) * $registros_por_pagina + 1;
$fin_registro = min($pagina_actual * $registros_por_pagina, $total_registros);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_visto'])) {
    $id_actividad = filter_input(INPUT_POST, 'id_actividad', FILTER_VALIDATE_INT);
    
    $sql = "UPDATE actividades SET fecha_visualizacion = NOW() WHERE id_actividad = ?";
    $stmt = $conexion_metadocs->prepare($sql);
    $stmt->bind_param("i", $id_actividad);
    $stmt->execute();
    
    echo json_encode(['success' => true]);
    exit;
}
?>