<?php 
require_once '../../helpers/conexio_graficas.php';
require_once '../../helpers/verificacion_roles.php';
require_once '../../backend/administrador/consulta_docs.php';
require_once '../../backend/administrador/consulta_para_grafica.php';
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
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
     <link rel="stylesheet" href="../../../componentes/css/admin/panel_control_graficas.css">
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
            
         


    <div class="container">
        <div class="header">
            <h1>Dashboard de Documentos</h1>
            <p>Análisis estadístico de documentos por mes y área</p>
        </div>

        <!-- Estadísticas generales -->
         <p><i class="bi bi-speedometer"></i> Resumen General</p>
        <div class="stats-grid">

            
           
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
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalArchivado; ?></div>
                <div class="stat-label">Documentos Archivados</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalCarpetas; ?></div>
                <div class="stat-label">Total Carpetas</div>
            </div>


        </div>


        <div class="system-info">
            <h2 class="section-title">
                <i class="bi bi-info-circle-fill"></i>
                Información del Sistema
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="bi bi-database-fill"></i>
                    </div>
                    <div class="info-details">
                        <h4>Base de Datos</h4>
                        <span>MySQL - Conectado</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="bi bi-hdd-stack-fill"></i>
                    </div>
                    <div class="info-details">
                        <h4>Servidor</h4>
                        <span><?php echo $host; ?></span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                       <i class="bi bi-calendar-fill"></i>
                    </div>
                    <div class="info-details">
                        <h4>Última Actualización</h4>
                        <span><?php echo date('d/m/Y H:i'); ?></span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                       <i class="bi bi-person-fill-gear"></i>
                    </div>
                    <div class="info-details">
                        <h4>Usuario Administrador</h4>
                        <span><?php echo htmlspecialchars($usuario['nombres']);?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
         <p><i class="bi bi-bar-chart-line"></i> Análisis y Estadísticas</p>
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
                <div class="chart-title">📋 Retencion documentos</div>
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
                estado_retencion,
                COUNT(*) as cantidad
            FROM documentos 
            GROUP BY estado_retencion
        ";
        $result = mysqli_query($conn, $query);
        
        $estados = [];
        $cantidadesEstado = [];
        while($row = mysqli_fetch_assoc($result)) {
            $estados[] = ucfirst($row['estado_retencion']);
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
 
        <p><i class="bi bi-bar-chart-line"></i> Usuarios del sistema</p>

        <div class="container">
       

        <div class="main-panel">
            <div class="stats-container">
                
                
                <div class="stats-list">
                    <div class="stat-row total">
                        <div class="stat-row-icon"><i class="bi bi-people-fill"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Total de Usuarios</div>
                            <div class="stat-main-value"><?php echo $total_usuarios; ?></div>
                            <div class="stat-detail">Usuarios registrados en el sistema</div>
                        </div>
                    </div>

                    <div class="stat-row active">
                        <div class="stat-row-icon"><i class="bi bi-person-check-fill"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Usuarios Activos</div>
                            <div class="stat-main-value"><?php echo $usuarios_activos; ?></div>
                            <div class="stat-detail"><?php echo round(($usuarios_activos/$total_usuarios)*100, 1); ?>% del total de usuarios</div>
                        </div>
                    </div>

                    <div class="stat-row inactive">
                        <div class="stat-row-icon"><i class="bi bi-person-fill-x"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Usuarios Inactivos</div>
                            <div class="stat-main-value"><?php echo $usuarios_inactivos; ?></div>
                            <div class="stat-detail"><?php echo round(($usuarios_inactivos/$total_usuarios)*100, 1); ?>% del total de usuarios</div>
                        </div>
                    </div>

                    <div class="stat-row areas">
                        <div class="stat-row-icon"><i class="bi bi-building-fill"></i></div>
                        <div class="stat-info">
                            <div class="stat-label">Áreas Activas</div>
                            <div class="stat-main-value"><?php echo $areas_unicas; ?></div>
                            <div class="stat-detail">Departamentos con usuarios asignados</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Distribución de Usuarios</h3>
                    <div class="chart-controls">
                        <button class="chart-btn active" onclick="cambiarGrafico('roles')">Por Roles</button>
                        <button class="chart-btn" onclick="cambiarGrafico('areas')">Por Áreas</button>
                        <button class="chart-btn" onclick="cambiarGrafico('estado')">Por Estado</button>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>

     <script>
        // Datos procesados de la base de datos
        const datosUsuarios = {
            roles: {
                'auditor': 1,
                'documentador': 3,
                'administrador': 4
            },
            areas: {
                'Área 1': 1,
                'Área 2': 1,
                'Área 3': 2,
                'Área 4': 4
            },
            estado: {
                'Activos': 6,
                'Inactivos': 2
            }
        };

        let chart;
        let tipoActual = 'roles';

        const colores = {
            roles: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            areas: ['#06b6d4', '#84cc16', '#f97316', '#ec4899'],
            estado: ['#10b981', '#ef4444']
        };

        function crearGrafico(tipo) {
            const ctx = document.getElementById('mainChart').getContext('2d');
            
            if (chart) {
                chart.destroy();
            }

            let datos, etiquetas, coloresFondo;
            
            switch(tipo) {
                case 'roles':
                    etiquetas = Object.keys(datosUsuarios.roles).map(rol => 
                        rol.charAt(0).toUpperCase() + rol.slice(1)
                    );
                    datos = Object.values(datosUsuarios.roles);
                    coloresFondo = colores.roles.slice(0, datos.length);
                    break;
                case 'areas':
                    etiquetas = Object.keys(datosUsuarios.areas);
                    datos = Object.values(datosUsuarios.areas);
                    coloresFondo = colores.areas.slice(0, datos.length);
                    break;
                case 'estado':
                    etiquetas = Object.keys(datosUsuarios.estado);
                    datos = Object.values(datosUsuarios.estado);
                    coloresFondo = colores.estado;
                    break;
            }

            const esEstado = tipo === 'estado';

            chart = new Chart(ctx, {
                type: esEstado ? 'doughnut' : 'bar',
                data: {
                    labels: etiquetas,
                    datasets: [{
                        label: 'Cantidad de usuarios',
                        data: datos,
                        backgroundColor: coloresFondo,
                        borderColor: coloresFondo.map(color => color + '80'),
                        borderWidth: 2,
                        borderRadius: esEstado ? 0 : 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: esEstado,
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255,255,255,0.2)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const porcentaje = ((context.parsed / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.parsed} (${porcentaje}%)`;
                                }
                            }
                        }
                    },
                    scales: esEstado ? {} : {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#6b7280'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#6b7280'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        function cambiarGrafico(tipo) {
            // Actualizar botones
            document.querySelectorAll('.chart-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Cambiar gráfico
            tipoActual = tipo;
            crearGrafico(tipo);
        }

       

       

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
