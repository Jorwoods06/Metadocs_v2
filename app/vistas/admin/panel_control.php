<?php 

require_once '../../helpers/verificacion_roles.php';
require_once '../../backend/administrador/consulta_docs.php';
AutorizacionRol('administrador');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Metadocs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
    <script src="../../../componentes/js/admin/grafica_documentos.js"></script>
</head>
<body>
    <header id="cabezote">
        <i class="bi bi-list" id="menu_opciones"></i>
        
    </header>

    <main id="cuerpo">
        <nav id="menu-lateral" class="menu-lateral">
            <figure id="img_menu">
                  <img src="../../../componentes/img/image.png" alt="imagen del menu lateral">
            </figure>
            <ul>
                <li>
                    <a href="../admin/panel_control.php" class="activo">
                        <i class="bi bi-bar-chart-line"></i>
                        Panel Control
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios">
                        <i class="bi bi-people"></i>
                        Gestión Usuarios
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li>
                            <a href="../../vistas/admin/creacion_usuario.php">
                                <i class="bi bi-person-plus"></i>
                                Crear usuario
                            </a>
                        </li>
                        <li>
                            <a href="../admin/ver_usuarios.php">
                                <i class="bi bi-eye"></i>
                                Ver usuario
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="../admin/admin_reporte.php">
                        <i class="bi bi-file-earmark-text"></i>
                        Reportes
                    </a>
                </li>

                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios">
                        <i class="bi bi-person"></i>
                        Usuario
                    </a>
                       <ul class="sub_menu usuario-submenu" id="sub_menu">
                        <li><a href="#" id="cerrar_sesion"><i class="bi bi-box-arrow-left"></i>Cerrar sesion</a></li>
                        <li><a href="../log/informacion_usuario.php"><i class="bi bi-info-circle"></i> Info usuario</a></li>
                        <li><a href="../log/nueva_contraseña.php"><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>

                <li class="solo_mobil">
                    <a href="#" id="solo_mobil">
                        <i class="bi bi-arrow-left"></i>
                        Volver
                    </a>
                </li>
            </ul>
        </nav>
       
        <section id="admin-contenido" class="admin">
            <h1>Panel control</h1>
            <?php
// config.php - Configuración de base de datos
$host = 'localhost';
$db_name = 'metadocs';
$username = 'root';
$password = '';

// Función para obtener conexión
function getConnection() {
    global $host, $db_name, $username, $password;
    
    $conn = mysqli_connect($host, $username, $password, $db_name);
    
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Configurar charset para evitar problemas con caracteres especiales
    mysqli_set_charset($conn, "utf8");
    
    return $conn;
}

// dashboard.php - Página principal con gráficos
$conn = getConnection();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Documentos</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
       
        .header {
            background: linear-gradient(135deg, #3D688A 0%, #2E5A7A 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #3D688A;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .chart-title {
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Dashboard de Documentos</h1>
            <p>Análisis estadístico de documentos por mes y área</p>
        </div>

        <!-- Estadísticas generales -->
        <div class="stats-grid">
            <?php
            // Total documentos
            $query = "SELECT COUNT(*) as total FROM documentos";
            $result = mysqli_query($conn, $query);
            $totalDocs = mysqli_fetch_assoc($result)['total'];

            // Total áreas
            $query = "SELECT COUNT(DISTINCT id_area) as total FROM documentos";
            $result = mysqli_query($conn, $query);
            $totalAreas = mysqli_fetch_assoc($result)['total'];

            // Documentos activos
            $query = "SELECT COUNT(*) as total FROM documentos WHERE estado_retencion = 'activo'";
            $result = mysqli_query($conn, $query);
            $docsActivos = mysqli_fetch_assoc($result)['total'];

            // Documentos rechazados
            $query = "SELECT COUNT(*) as total FROM documentos WHERE estado = 'rechazado'";
            $result = mysqli_query($conn, $query);
            $docsRechazados = mysqli_fetch_assoc($result)['total'];
            ?>
            
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalDocs; ?></div>
                <div class="stat-label">Total Documentos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalAreas; ?></div>
                <div class="stat-label">Áreas Diferentes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $docsActivos; ?></div>
                <div class="stat-label">Documentos Activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $docsRechazados; ?></div>
                <div class="stat-label">Documentos Rechazados</div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="charts-grid">
            <!-- Gráfico: Documentos por mes -->
            <div class="chart-container">
                <div class="chart-title">📅 Documentos Subidos por Mes</div>
                <canvas id="documentosPorMes"></canvas>
            </div>

            <!-- Gráfico: Documentos por área -->
            <div class="chart-container">
                <div class="chart-title">🏢 Documentos por Área</div>
                <canvas id="documentosPorArea"></canvas>
            </div>

            <!-- Gráfico: Estado de documentos -->
            <div class="chart-container">
                <div class="chart-title">📋 Estado de Documentos</div>
                <canvas id="estadoDocumentos"></canvas>
            </div>

            <!-- Gráfico: Tipo de documentos -->
            <div class="chart-container">
                <div class="chart-title">📄 Tipos de Documentos</div>
                <canvas id="tipoDocumentos"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Paleta de colores complementarios basada en #3D688A
        const colorPalette = {
            primary: '#3D688A',
            secondary: '#5B8DB3',
            accent1: '#8AAFCC',
            accent2: '#B3D1E6',
            complement1: '#121f29',
            complement2: '#A67C52',
            success: '#243E52',
            warning: '#3d8a86',
            danger: '#B35B5B',
            info: '#5B8AB3'
        };

        // Datos para gráfico de documentos por mes
        <?php
        $query = "
            SELECT 
                DATE_FORMAT(fecha_creacion, '%Y-%m') as mes,
                COUNT(*) as cantidad
            FROM documentos 
            GROUP BY DATE_FORMAT(fecha_creacion, '%Y-%m')
            ORDER BY mes
        ";
        $result = mysqli_query($conn, $query);
        
        $meses = [];
        $cantidades = [];
        while($row = mysqli_fetch_assoc($result)) {
            $meses[] = $row['mes'];
            $cantidades[] = $row['cantidad'];
        }
        ?>

        const ctx1 = document.getElementById('documentosPorMes').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($meses); ?>,
                datasets: [{
                    label: 'Documentos Subidos',
                    data: <?php echo json_encode($cantidades); ?>,
                    borderColor: colorPalette.primary,
                    backgroundColor: colorPalette.primary + '20',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colorPalette.primary,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e0e0e0'
                        }
                    },
                    x: {
                        grid: {
                            color: '#e0e0e0'
                        }
                    }
                }
            }
        });

        // Datos para gráfico de documentos por área
        <?php
        $query = "
           SELECT documentos.id_area, area_acceso.nombre, COUNT(*) AS cantidad
            FROM documentos
            JOIN area_acceso ON area_acceso.id_area = documentos.id_area
            GROUP BY documentos.id_area, area_acceso.nombre
            ORDER BY cantidad DESC;

        ";
        $result = mysqli_query($conn, $query);
        
        $areas = [];
        $cantidadesArea = [];
        while($row = mysqli_fetch_assoc($result)) {
            $areas[] = 'Área ' . $row['nombre'];
            $cantidadesArea[] = $row['cantidad'];
        }
        ?>

        const ctx2 = document.getElementById('documentosPorArea').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($areas); ?>,
                datasets: [{
                    label: 'Cantidad de Documentos',
                    data: <?php echo json_encode($cantidadesArea); ?>,
                    backgroundColor: [
                        colorPalette.primary,
                        colorPalette.secondary,
                        colorPalette.accent1,
                        colorPalette.accent2,
                        colorPalette.complement1,
                        colorPalette.complement2,
                        colorPalette.success,
                        colorPalette.warning
                    ],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e0e0e0'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Datos para gráfico de estado de documentos
        <?php
        $query = "
            SELECT 
                estado,
                COUNT(*) as cantidad
            FROM documentos 
            GROUP BY estado
        ";
        $result = mysqli_query($conn, $query);
        
        $estados = [];
        $cantidadesEstado = [];
        while($row = mysqli_fetch_assoc($result)) {
            $estados[] = ucfirst($row['estado']);
            $cantidadesEstado[] = $row['cantidad'];
        }
        ?>

        const ctx3 = document.getElementById('estadoDocumentos').getContext('2d');
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($estados); ?>,
                datasets: [{
                    data: <?php echo json_encode($cantidadesEstado); ?>,
                    backgroundColor: [
                        colorPalette.primary,
                        colorPalette.success,
                        colorPalette.warning,
                        colorPalette.danger
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '60%'
            }
        });

        // Datos para gráfico de tipo de documentos
        <?php
        $query = "
            SELECT 
                tipo,
                COUNT(*) as cantidad
            FROM documentos 
            GROUP BY tipo
            ORDER BY cantidad DESC
        ";
        $result = mysqli_query($conn, $query);
        
        $tipos = [];
        $cantidadesTipo = [];
        while($row = mysqli_fetch_assoc($result)) {
            $tipos[] = strtoupper($row['tipo']);
            $cantidadesTipo[] = $row['cantidad'];
        }
        ?>

        const ctx4 = document.getElementById('tipoDocumentos').getContext('2d');
        new Chart(ctx4, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($tipos); ?>,
                datasets: [{
                    data: <?php echo json_encode($cantidadesTipo); ?>,
                    backgroundColor: [
                        colorPalette.primary,
                        colorPalette.secondary,
                        colorPalette.complement1,
                        colorPalette.complement2,
                        colorPalette.accent1,
                        colorPalette.accent2
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php
// Cerrar la conexión al final
mysqli_close($conn);
?>
            
        </section>

      <script></script>
    </main>

    
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>

</html>
