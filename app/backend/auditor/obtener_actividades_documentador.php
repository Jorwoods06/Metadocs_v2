<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../helpers/conexion_bd.php';


$pagina = isset($_GET['pagina'])
    ? filter_var($_GET['pagina'], FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]])
    : 1;

$limite = isset($_GET['limite'])
    ? filter_var($_GET['limite'], FILTER_VALIDATE_INT, ["options" => ["default" => 10, "min_range" => 1, "max_range" => 100]])
    : 10;

$busqueda = isset($_GET['busqueda'])
    ? filter_var(trim($_GET['busqueda']), FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    : '';

$filtro_accion = isset($_GET['filtro_accion'])
    ? filter_var(trim($_GET['filtro_accion']),FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    : '';

$filtro_archivo = isset($_GET['filtro_archivo'])
    ? filter_var(trim($_GET['filtro_archivo']),FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    : '';

$offset = ($pagina - 1) * $limite;


$sql_base = "SELECT usuarios.nombres AS nombre, 
                    pista_auditoria.accion, 
                    CASE 
                        WHEN pista_auditoria.entidad = 'documento' THEN 'Documento' 
                        WHEN pista_auditoria.entidad = 'expediente' THEN 'Expediente' 
                        ELSE 'No' 
                    END AS archivo, 
                    CASE 
                        WHEN pista_auditoria.entidad = 'documento' THEN documentos.titulo 
                        WHEN pista_auditoria.entidad = 'expediente' THEN expedientes.nombre 
                        ELSE 'Sin archivo' 
                    END AS titulo,
                    pista_auditoria.fecha_accion AS fecha 
             FROM pista_auditoria 
             JOIN usuarios ON pista_auditoria.id_usuario = usuarios.id_usuario 
             LEFT JOIN documentos ON pista_auditoria.entidad = 'documento' AND pista_auditoria.entidad_id = documentos.id_documento 
             LEFT JOIN expedientes ON pista_auditoria.entidad = 'expediente' AND pista_auditoria.entidad_id = expedientes.id_expediente 
             WHERE pista_auditoria.rol = 'documentador'";


$condiciones = [];
$params = [];
$types = '';

if (!empty($busqueda)) {
    $condiciones[] = "(usuarios.nombres LIKE ? OR pista_auditoria.accion LIKE ? OR documentos.titulo LIKE ? OR expedientes.nombre LIKE ?)";
    $busqueda_param = "%$busqueda%";
    $params = array_merge($params, [$busqueda_param, $busqueda_param, $busqueda_param, $busqueda_param]);
    $types .= 'ssss';
}

if (!empty($filtro_accion)) {
    $condiciones[] = "pista_auditoria.accion = ?";
    $params[] = $filtro_accion;
    $types .= 's';
}

if (!empty($filtro_archivo)) {
    if ($filtro_archivo === 'Documento') {
        $condiciones[] = "pista_auditoria.entidad = 'documento'";
    } elseif ($filtro_archivo === 'Expediente') {
        $condiciones[] = "pista_auditoria.entidad = 'expediente'";
    } elseif ($filtro_archivo === 'No') {
        $condiciones[] = "pista_auditoria.entidad IS NULL OR pista_auditoria.entidad = ''";
    }
}


if (!empty($condiciones)) {
    $sql_base .= " AND " . implode(" AND ", $condiciones);
}


$sql_count = "SELECT COUNT(*) as total FROM ($sql_base) as subconsulta";


$stmt_count = $conexion_metadocs->prepare($sql_count);
if (!empty($params)) {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$resultado_count = $stmt_count->get_result();
$total_registros = $resultado_count->fetch_assoc()['total'];


$sql_datos = $sql_base . " ORDER BY pista_auditoria.fecha_accion DESC LIMIT ? OFFSET ?";
$params[] = $limite;
$params[] = $offset;
$types .= 'ii';

$stmt_datos = $conexion_metadocs->prepare($sql_datos);
if (!empty($params)) {
    $stmt_datos->bind_param($types, ...$params);
}
$stmt_datos->execute();
$resultado_datos = $stmt_datos->get_result();


$actividades = [];
while ($fila = $resultado_datos->fetch_assoc()) {
 
    $fecha_formateada = date('d/m/Y H:i', strtotime($fila['fecha']));

    $actividades[] = [
        'nombre' => $fila['nombre'],
        'accion' => $fila['accion'],
        'archivo' => $fila['archivo'],
        'titulo' => $fila['titulo'] ?? 'Sin título',
        'fecha' => $fecha_formateada,
    ];
}

$total_paginas = ceil($total_registros / $limite);
$registro_inicio = $offset + 1;
$registro_fin = min($offset + $limite, $total_registros);


$respuesta = [
    'success' => true,
    'data' => $actividades,
    'pagination' => [
        'pagina_actual' => $pagina,
        'total_paginas' => $total_paginas,
        'total_registros' => $total_registros,
        'registros_por_pagina' => $limite,
        'registro_inicio' => $registro_inicio,
        'registro_fin' => $registro_fin,
        'hay_anterior' => $pagina > 1,
        'hay_siguiente' => $pagina < $total_paginas
    ]
];

$stmt_count->close();
$stmt_datos->close();
$conexion_metadocs->close();

echo json_encode($respuesta);
