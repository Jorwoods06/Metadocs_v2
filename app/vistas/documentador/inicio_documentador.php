<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentador | Metadocs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <link rel="stylesheet" href="../../../componentes/css/documentador/que.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
    <script src="../../../componentes/js/documentador/inicio_documentador.js"></script>
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
                        <a href="" class="activo">
                            <i class="bi bi-house-door"></i>
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="ver_documentos.php">
                            <i class="bi bi-file-earmark-text"></i>
                            Archivos
                        </a>
                    </li>
                    <li>
                        <a href="solicitudes_doc.php">
                            <i class="bi bi-envelope-paper"></i>
                            Solicitudes
                        </a>
                    </li>
                    <!-- User Management -->  
                    <li class="gestion-usuarios">
                        <a href="#" id="cerrado-usuarios">
                            <i class="bi bi-person"></i>
                            Documentador
                        </a>
                        <ul class="sub_menu usuario-submenu" id="sub_menu">
                            <li>
                                <a href="../documentador/info_documentador.php">
                                    <i class="bi bi-info-circle"></i> 
                                    Info documentador
                                </a>
                            </li>
                            <li>
                                <a href="cambiar_contraseña.php">
                                    <i class="bi bi-key-fill"></i> 
                                    Cambiar contraseña
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Mobile Only -->
                    <li class="solo_mobil">
                        <a href="#" id="solo_mobil">
                            <i class="bi bi-arrow-left-circle"></i>
                            Volver
                        </a>
                    </li>
                </div>
                <!-- Logout Section -->
                <li class="cerrar-sesion-separado">
                    <a href="#" id="cerrar_sesion">
                        <i class="bi bi-box-arrow-left"></i>
                        Cerrar sesión
                    </a>
                </li>
            </ul>
        </nav>
        
        <section id="admin-contenido" class="admin">
            <div class="container">
                <!-- Header -->
                <header class="header">
                    <div class="header-content">
                        <h1 class="header-title">Inicio</h1>
                        <div class="user-info">
                            <div>Bienvenido Documentador</div>
                        </div>
                    </div>
                </header>

                <!-- Statistics -->
                <section class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon pending-requests">
                            <i class="bi bi-envelope-exclamation"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Solicitudes Sin Revisar</div>
                        <div class="stat-change positive">+2 esta semana</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon uploaded-docs">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Documentos Subidos</div>
                        <div class="stat-change positive">+8 este mes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon created-expedients">
                            <i class="bi bi-folder-plus"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Expedientes Creados</div>
                        <div class="stat-change positive">+3 este mes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon approved-items">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Archivos Aprobados</div>
                        <div class="stat-change positive">+12 este mes</div>
                    </div>
                </section>

                <div class="main-content">
                    <div>
                        <!-- Quick Actions -->
                        <section class="quick-actions">
                            <h2 class="section-title">Acciones Rápidas</h2>
                            <div class="actions-grid">
                               

                                <a href="solicitudes_doc.php" class="action-card">
                                    <div class="action-icon icon-requests">
                                        <i class="bi bi-envelope-open"></i>
                                    </div>
                                    <div class="action-title">
                                        Ver Solicitudes
                                        <span class="action-badge">5</span>
                                    </div>
                                    <div class="action-description">
                                        Revisar solicitudes de documentos realizadas por auditores
                                    </div>
                                </a>

                                <a href="ver_documentos.php" class="action-card">
                                    <div class="action-icon icon-files">
                                        <i class="bi bi-files"></i>
                                    </div>
                                    <div class="action-title">Ver Archivos</div>
                                    <div class="action-description">
                                        Consultar todos los documentos y expedientes subidos
                                    </div>
                                </a>

                                

                              

                                <a href="info_documentador.php" class="action-card">
                                    <div class="action-icon icon-user">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="action-title">Información del Usuario</div>
                                    <div class="action-description">
                                        Gestionar perfil y configuración de la cuenta
                                    </div>
                                </a>
                            </div>
                        </section>
                    </div>

                    <!-- Recent Activity -->
                    <aside>
                        <section class="recent-activity">
                            <h2 class="section-title">Actividad Reciente</h2>
                            
                            <div class="activity-item">
                                <div class="activity-icon uploaded icon-uploaded"></div>
                                <div class="activity-content"> 
                                    <div class="activity-text">Documento "bucles y arreglos kotlin" subido</div>
                                    <div class="activity-time">Hace 2 horas</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon created icon-created"></div>
                                <div class="activity-content">
                                    <div class="activity-text">Expediente "que ._." creado</div>
                                    <div class="activity-time">Hace 4 horas</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon uploaded icon-uploaded"></div>
                                <div class="activity-content">
                                    <div class="activity-text">Documento "1114240641_Jorge_Galeano_2825817.pdf" subido</div>
                                    <div class="activity-time">Ayer</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon request icon-request-received"></div>
                                <div class="activity-content">
                                    <div class="activity-text">Nueva solicitud de documento recibida</div>
                                    <div class="activity-time">Hace 2 días</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon created icon-created"></div>
                                <div class="activity-content">
                                    <div class="activity-text">Expediente "adsdasd" creado</div>
                                    <div class="activity-time">Hace 3 días</div>
                                </div>
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal cerrar sesión (incluir el modal aquí) -->
      <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
      <script src="../../../componentes/js/documentador/dashboard_documentador.js"></script>
</body>
</html>