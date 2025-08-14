<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentador | Metadocs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <link rel="stylesheet" href="../../../componentes/css/documentador/inicio_documentador.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
    <script src="../../../componentes/js/documentador/inicio_documentador.js"></script>
</head>
<body>
        <header id="cabezote">
        <i class="fas fa-bars" id="menu_opciones"></i>
    </header>

    <main id="cuerpo">
         <nav id="menu-lateral" class="menu-lateral">
            <figure id="img_menu">
                <img src="../../../componentes/img/image.png" alt="imagen del menu lateral">
            </figure>
            <ul>
             <div class="menu-opciones-principales">
                <li><a href="#" class="activo"><i class="fas fa-home"></i>Inicio</a></li>
                <li><a href="ver_documentos.php"><i class="fas fa-file-alt"></i>Archivos</a></li>
                <li><a href="solicitudes_doc.php" ><i class="fas fa-envelope"></i>Solicitudes</a></li>
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios">
                        <i class="fas fa-user"></i>Documentador
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                     
                        <li><a href="info_documentador.php" ><i class="fas fa-info-circle"></i> Info documentador</a></li>
                        <li><a href="cambiar_contraseña.php"><i class="fas fa-key"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>
                <li class="solo_mobil">
                    <a href="#" id="solo_mobil"><i class="fas fa-arrow-left"></i>Volver</a>
                </li>
                  </div>
                   <li  class="cerrar-sesion-separado"><a href="#" id="cerrar_sesion"><i class="fas fa-sign-out-alt"></i>Cerrar sesion</a></li>
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
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Solicitudes Sin Revisar</div>
                        <div class="stat-change positive">+2 esta semana</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon uploaded-docs">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Documentos Subidos</div>
                        <div class="stat-change positive">+8 este mes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon created-expedients">
                            <i class="fas fa-folder-plus"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Expedientes Creados</div>
                        <div class="stat-change positive">+3 este mes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon approved-items">
                            <i class="fas fa-check-circle"></i>
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
                                        <i class="fas fa-envelope-open"></i>
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
                                        <i class="fas fa-copy"></i>
                                    </div>
                                    <div class="action-title">Ver Archivos</div>
                                    <div class="action-description">
                                        Consultar todos los documentos y expedientes subidos
                                    </div>
                                </a>

                                

                              

                                <a href="info_documentador.php" class="action-card">
                                    <div class="action-icon icon-user">
                                        <i class="fas fa-user-circle"></i>
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
                        <section class="recent-activitys">
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

      <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
      <script src="../../../componentes/js/documentador/dashboard_documentador.js"></script>
</body>
</html>