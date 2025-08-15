<?php 
require_once '../../helpers/conexion_bd.php';
require_once '../../helpers/verificacion_roles.php';
require_once '../../backend/administrador/consulta_para_grafica.php';
require_once '../../backend/administrador/datos_panel.php'; 
AutorizacionRol('administrador');

// Obtener todos los datos para las gráficas
$datosPanelControl = obtenerDatosPanelControl($conexion_metadocs);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Metadocs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
       
        <div class="menu-opciones-principales">
            <li>
                <a href="#" class="activo" >
                    <i class="fas fa-chart-line"></i>
                    Panel Control
                </a>
            </li>

              <li>
                <a href="../admin/pista_auditoria.php" >
                    <i class="fas fa-clipboard-check"></i>
                    Actividades usuarios
                </a>
            </li>

            <li class="gestion_usuario">
                <a href="#" id="gestion-usuarios"><i class="fas fa-users"></i> Gestión Usuarios</a>
                <ul class="sub_menu gestion-submenu" id="sub_menu">
                    <li><a href="../../vistas/admin/creacion_usuario.php"><i class="fas fa-user-plus"></i> Crear usuario</a></li>
                    <li><a href="../admin/ver_usuarios.php" ><i class="fas fa-eye"></i> Ver usuario</a></li>
                </ul>
            </li>
            
       
            
            <li class="gestion-usuarios">
                <a href="#" id="cerrado-usuarios"><i class="fas fa-user"></i> Admin</a>
                <ul class="sub_menu usuario-submenu" id="sub_menu">
                    <li><a href="../log/informacion_usuario.php"><i class="fas fa-info-circle"></i> Info usuario</a></li>
                    <li><a href="cambiar_contraseña.php"><i class="fas fa-key"></i> Cambiar contraseña</a></li>
                </ul>
            </li>
            
            <li class="solo_mobil">
                <a href="#" id="solo_mobil"><i class="fas fa-arrow-left"></i> Volver</a></li>
        </div>

       
        <li class="cerrar-sesion-separado">
            <a href="#" id="cerrar_sesion"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
        </li>
    </ul>
</nav>
       
       <section id="admin-contenido" class="admin">
            
         


    <div class="container">
        <div class="header">
            <h1>Dashboard de Documentos</h1>
            <p>Análisis estadístico de archivos</p>
        </div>

        <!-- Estadísticas generales -->
        <p class="section-header resumen"><i class="bi bi-speedometer"></i> Resumen General</p>
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
    <p class="section-header resumen"><i class="bi bi-info-circle-fill"></i> Informacion del sistema</p>

        <div class="system-info">
            
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
                        <span><?php date_default_timezone_set('America/Bogota'); echo date('d/m/Y H:i'); ?></span>
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

        <!-- Gráficos de Documentos - SECCIÓN MEJORADA -->
        <p class="section-header analisis"><i class="bi bi-bar-chart-line"></i> Análisis y Estadísticas</p>
        <div class="main-panel">
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Análisis de Documentos</h3>
                    <div class="chart-controls">
                        <button class="chart-btn active" onclick="cambiarGraficoDocumentos('mes')">Por Mes</button>
                        <button class="chart-btn" onclick="cambiarGraficoDocumentos('area')">Por Área</button>
                        <button class="chart-btn" onclick="cambiarGraficoDocumentos('estado')">Por Estado</button>
                        <button class="chart-btn" onclick="cambiarGraficoDocumentos('tipo')">Por Tipo</button>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="documentosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusión del archivo JavaScript separado con datos PHP -->
    <script src="../../../componentes/js/admin/panel_control_charts.js"></script>
    <script>
        // Inicializar los datos desde PHP
        initializeDatosDocumentos(<?php echo json_encode($datosPanelControl['documentos']); ?>);
    </script>
 
       <p class="section-header usuarios"><i class="bi bi-people-fill"></i> Usuarios del sistema</p>

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
// Inicializar datos de usuarios desde PHP
initializeDatosUsuarios(<?php echo json_encode($datosPanelControl['usuarios']); ?>);
</script>


<?php
// Cerrar la conexión al final
mysqli_close($conexion_metadocs);
?>
            
        </section>

      <script></script>
    </main>

    
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>

</html>