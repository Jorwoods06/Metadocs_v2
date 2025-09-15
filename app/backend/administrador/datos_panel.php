<?php

// Archivo PHP separado para manejar todas las consultas y datos del panel de control

require_once '../../helpers/conexion_bd.php';


// Obtiene datos para gráfico de documentos por mes

function obtenerDocumentosPorMes($conexion)
{
    $query = "
        SELECT 
            DATE_FORMAT(fecha_creacion, '%Y-%m') as mes,
            COUNT(*) as cantidad
        FROM documentos 
        GROUP BY DATE_FORMAT(fecha_creacion, '%Y-%m')
        ORDER BY mes
    ";
    $result = mysqli_query($conexion, $query);

    $meses = [];
    $cantidades = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $meses[] = $row['mes'];
        $cantidades[] = $row['cantidad'];
    }

    return ['labels' => $meses, 'data' => $cantidades, 'tipo' => 'line'];
}


// Obtiene datos para gráfico de documentos por área

function obtenerDocumentosPorArea($conexion)
{
    $query = "
        SELECT documentos.id_area, area_acceso.nombre, COUNT(*) AS cantidad
        FROM documentos
        JOIN area_acceso ON area_acceso.id_area = documentos.id_area
        GROUP BY documentos.id_area, area_acceso.nombre
        ORDER BY cantidad DESC;
    ";
    $result = mysqli_query($conexion, $query);

    $areasDoc = [];
    $cantidadesArea = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $areasDoc[] = 'Área ' . $row['nombre'];
        $cantidadesArea[] = $row['cantidad'];
    }

    return ['labels' => $areasDoc, 'data' => $cantidadesArea, 'tipo' => 'bar'];
}


// Obtiene datos para gráfico de documentos por estado

function obtenerDocumentosPorEstado($conexion)
{
    $query = "
        SELECT 
            estado_retencion,
            COUNT(*) as cantidad
        FROM documentos 
        GROUP BY estado_retencion
    ";
    $result = mysqli_query($conexion, $query);

    $estadosDoc = [];
    $cantidadesEstado = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $estadosDoc[] = ucfirst($row['estado_retencion']);
        $cantidadesEstado[] = $row['cantidad'];
    }

    return ['labels' => $estadosDoc, 'data' => $cantidadesEstado, 'tipo' => 'doughnut'];
}


// Obtiene datos para gráfico de documentos por tipo

function obtenerDocumentosPorTipo($conexion)
{
    $query = "
        SELECT 
            tipo,
            COUNT(*) as cantidad
        FROM documentos 
        GROUP BY tipo
        ORDER BY cantidad DESC
    ";
    $result = mysqli_query($conexion, $query);

    $tiposDoc = [];
    $cantidadesTipo = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tiposDoc[] = strtoupper($row['tipo']);
        $cantidadesTipo[] = $row['cantidad'];
    }

    return ['labels' => $tiposDoc, 'data' => $cantidadesTipo, 'tipo' => 'pie'];
}


// Obtiene datos para gráfico de usuarios por rol

function obtenerUsuariosPorRol($conexion)
{
    $query = "SELECT rol, COUNT(*) AS cantidad 
              FROM usuarios
              GROUP BY rol;";

    $result = mysqli_query($conexion, $query);

    $roles = [];
    $cantidad_rol = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $roles[] = strtoupper($row['rol']);
        $cantidad_rol[] = $row['cantidad'];
    }

    return ['labels' => $roles, 'data' => $cantidad_rol];
}


// Obtiene datos para gráfico de usuarios por área

function obtenerUsuariosPorArea($conexion)
{
    $query = "SELECT usuarios.id_area, area_acceso.nombre, COUNT(*) AS cantidad 
              FROM usuarios 
              JOIN area_acceso ON area_acceso.id_area = usuarios.id_area 
              GROUP BY usuarios.id_area, area_acceso.nombre 
              ORDER BY cantidad DESC;";

    $result = mysqli_query($conexion, $query);

    $areas = [];
    $cantidad_area = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $areas[] = strtoupper($row['nombre']);
        $cantidad_area[] = $row['cantidad'];
    }

    return ['labels' => $areas, 'data' => $cantidad_area];
}


//  Obtiene datos para gráfico de usuarios por estado

function obtenerUsuariosPorEstado($conexion)
{
    $query = "SELECT usuarios.estado, COUNT(*) AS cantidad 
              FROM usuarios 
              GROUP BY estado;";

    $result = mysqli_query($conexion, $query);

    $estados = [];
    $cantidad_estado = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $estados[] = strtoupper($row['estado']);
        $cantidad_estado[] = $row['cantidad'];
    }

    return ['labels' => $estados, 'data' => $cantidad_estado];
}


// Obtiene todos los datos de documentos para las gráficas

function obtenerDatosDocumentos($conexion)
{
    return [
        'mes' => obtenerDocumentosPorMes($conexion),
        'area' => obtenerDocumentosPorArea($conexion),
        'estado' => obtenerDocumentosPorEstado($conexion),
        'tipo' => obtenerDocumentosPorTipo($conexion)
    ];
}


//  Obtiene todos los datos de usuarios para las gráficas

function obtenerDatosUsuarios($conexion)
{
    return [
        'roles' => obtenerUsuariosPorRol($conexion),
        'areas' => obtenerUsuariosPorArea($conexion),
        'estado' => obtenerUsuariosPorEstado($conexion)
    ];
}


// Función para obtener todos los datos necesarios para el panel


function obtenerDatosPanelControl($conexion)
{
    return [
        'documentos' => obtenerDatosDocumentos($conexion),
        'usuarios' => obtenerDatosUsuarios($conexion)
    ];
}


if (basename($_SERVER['PHP_SELF']) == 'datos_panel.php') {
    header('Content-Type: application/json');
    $datos = obtenerDatosPanelControl($conexion_metadocs);
    echo json_encode($datos);
    mysqli_close($conexion_metadocs);
}
