<?php
require_once '../../helpers/conexion_bd.php';

$pagina = isset($_GET['pagina']) 
    ? filter_var($_GET['pagina'], FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]]) 
    : 1;

$registros_por_pagina = 10;
$offset = ($pagina - 1) * $registros_por_pagina;

$filtro_accion = isset($_GET['accion']) ? htmlspecialchars(trim($_GET['accion'])) : '';
$filtro_archivo = isset($_GET['archivo']) ? htmlspecialchars(trim($_GET['archivo'])) : '';
$busqueda = isset($_GET['busqueda']) ? htmlspecialchars(trim($_GET['busqueda'])) : '';

$where_conditions = [];
$params = [];

// Filtros dinámicos
if (!empty($filtro_accion)) {
    $where_conditions[] = "pista_auditoria.accion = ?";
    $params[] = $filtro_accion;
}

if (!empty($filtro_archivo)) {
    if ($filtro_archivo === 'null') {
        $where_conditions[] = "pista_auditoria.entidad IS NULL";
    } else {
        $where_conditions[] = "pista_auditoria.entidad = ?";
        $params[] = $filtro_archivo;
    }
}

if (!empty($busqueda)) {
    $where_conditions[] = "(usuarios.nombres LIKE ? OR pista_auditoria.accion LIKE ? OR 
                        (pista_auditoria.entidad = 'documento' AND documentos.titulo LIKE ?) OR 
                        (pista_auditoria.entidad = 'expediente' AND expedientes.nombre LIKE ?))";
    $busqueda_param = '%' . $busqueda . '%';
    $params = array_merge($params, [$busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param]);
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Consulta principal
$sql = "SELECT 
    usuarios.nombres, 
    pista_auditoria.rol, 
    pista_auditoria.accion, 
    pista_auditoria.entidad AS Archivo, 
    CASE 
        WHEN pista_auditoria.entidad = 'documento' THEN documentos.titulo 
        WHEN pista_auditoria.entidad = 'expediente' THEN expedientes.nombre 
        ELSE NULL 
    END AS titulo, 
    pista_auditoria.fecha_accion 
FROM pista_auditoria 
JOIN usuarios ON pista_auditoria.id_usuario = usuarios.id_usuario 
LEFT JOIN documentos ON pista_auditoria.entidad = 'documento' AND pista_auditoria.entidad_id = documentos.id_documento 
LEFT JOIN expedientes ON pista_auditoria.entidad = 'expediente' AND pista_auditoria.entidad_id = expedientes.id_expediente 
$where_clause
ORDER BY pista_auditoria.fecha_accion DESC 
LIMIT ? OFFSET ?";

// Agregar límites de paginación
$params[] = $registros_por_pagina;
$params[] = $offset;

// Consulta para contar total de registros
$sql_count = "SELECT COUNT(*) as total 
FROM pista_auditoria 
JOIN usuarios ON pista_auditoria.id_usuario = usuarios.id_usuario 
LEFT JOIN documentos ON pista_auditoria.entidad = 'documento' AND pista_auditoria.entidad_id = documentos.id_documento 
LEFT JOIN expedientes ON pista_auditoria.entidad = 'expediente' AND pista_auditoria.entidad_id = expedientes.id_expediente 
$where_clause";

// Ejecutar consulta principal
$stmt = $conexion_metadocs->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params) - 2) . "ii", ...$params); 
$stmt->execute();
$resultado = $stmt->get_result();

$actividades = [];

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $actividades[] = $fila;
    }

    // Ejecutar conteo total
    if (!empty($params)) {
        $stmt_count = $conexion_metadocs->prepare($sql_count);
        if (count($params) > 2) { 
            $stmt_count->bind_param(str_repeat('s', count($params) - 2), ...array_slice($params, 0, -2));
        }
        $stmt_count->execute();
        $resultado_count = $stmt_count->get_result();
    } else {
        $resultado_count = mysqli_query($conexion_metadocs, $sql_count);
    }

    if ($resultado_count) {
        $total_registros = mysqli_fetch_assoc($resultado_count)['total'];
        $total_paginas = ceil($total_registros / $registros_por_pagina);

        $paginas_mostrar = [];
        $rango = 2;

        if ($pagina > $rango + 2) {
            $paginas_mostrar[] = 1;
            if ($pagina > $rango + 3) {
                $paginas_mostrar[] = '...';
            }
        }

        for ($i = max(1, $pagina - $rango); $i <= min($total_paginas, $pagina + $rango); $i++) {
            $paginas_mostrar[] = $i;
        }

        if ($pagina < $total_paginas - $rango - 1) {
            if ($pagina < $total_paginas - $rango - 2) {
                $paginas_mostrar[] = '...';
            }
            $paginas_mostrar[] = $total_paginas;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $actividades,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas,
            'total_registros' => $total_registros,
            'registros_por_pagina' => $registros_por_pagina,
            'paginas_mostrar' => $paginas_mostrar,
            'mostrar_anterior' => $pagina > 1,
            'mostrar_siguiente' => $pagina < $total_paginas,
            'rango_inicio' => $offset + 1,
            'rango_fin' => min($offset + $registros_por_pagina, $total_registros)
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'Error al contar registros: ' . mysqli_error($conexion_metadocs)
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Error al obtener actividades: ' . mysqli_error($conexion_metadocs)
    ]);
}


mysqli_close($conexion_metadocs);
