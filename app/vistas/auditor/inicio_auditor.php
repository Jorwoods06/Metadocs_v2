<?php
require_once '../../../app/backend/auditor/inicio_auditor.php';
require_once '../../helpers/verificacion_roles.php';
require_once '../../helpers/conexion_bd.php';

AutorizacionRol('auditor');



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor | Metadocs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/admin/control.css">
    <script src="../../../componentes/js/documentador/ver_documentos.js"></script>
    <script src="../../../componentes/js/admin/panel.js"></script>
    <link rel="stylesheet" href="../../../componentes/css/auditor/inicio_auditor.css">
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
                    <li>
                        <a href="#" class="activo">
                            <i class="fas fa-home"></i>
                            Inicio
                        </a>
                    </li>
                    <li class="gestion_usuario">
                        <a href="#" id="gestion-usuarios">
                            <i class="fas fa-file-alt"></i>
                            Gestión Archivos
                        </a>
                        <ul class="sub_menu gestion-submenu" id="sub_menu">
                            <li><a href="recibir_documentos.php"><i class="fas fa-envelope"></i>pendientes</a></li>
                            <li><a href="archivos_auditor.php"><i class="fas fa-eye"></i>Archivos</a></li>
                            <li><a href="solicitar_documento.php"><i class="fa-solid fa-file-arrow-down"></i> Solicitar archivos</a></li>
                            <li><a href="archivo_historico.php"><i class="fas fa-history"></i> Archivo historico</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="../../vistas/auditor/pista_auditoria.php">
                            <i class="fas fa-list-check"></i>
                            Pista auditoria
                        </a>
                    </li>

                    <li class="gestion-usuarios">
                        <a href="#" id="cerrado-usuarios">
                            <i class="fas fa-user"></i>
                            Auditor
                        </a>
                        <ul class="sub_menu usuario-submenu" id="sub_menu">
                            <li><a href="../../vistas/auditor/info_auditor.php"><i class="fas fa-info-circle"></i> Info auditor</a></li>
                            <li><a href="cambiar_contraseña.php"><i class="fas fa-key"></i> Cambiar contraseña</a></li>
                        </ul>
                    </li>

                    <li class="solo_mobil">
                        <a href="#" id="solo_mobil">
                            <i class="fas fa-arrow-left"></i>
                            Volver
                        </a>
                    </li>
                </div>

                <li class="cerrar-sesion-separado">
                    <a href="#" id="cerrar_sesion"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
                </li>
            </ul>
        </nav>

        <section id="admin-contenido" class="admin">
            <div class="container">

                <header class="header">
                    <div class="header-content">
                        <h1 class="header-title">Inicio</h1>
                        <div class="user-info">
                            <div>Bienvenido <?php echo htmlspecialchars($nombre_completo); ?></div>
                        </div>
                    </div>
                </header>

                <section class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $documentos_pendientes_total; ?></div>
                        <div class="stat-label">Archivos Pendientes</div>
                        <div class="stat-change positive">+<?php echo $documentos_pendientes_cambio; ?> esta semana</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_documentos; ?></div>
                        <div class="stat-label">Total Documentos</div>
                        <div class="stat-change positive">+<?php echo $total_documentos_cambio; ?> este mes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $expedientes_activos_total; ?></div>
                        <div class="stat-label">Expedientes Activos</div>
                        <div class="stat-change positive">+<?php echo $expedientes_activos_cambio; ?> este mes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $acciones_realizadas_total; ?></div>
                        <div class="stat-label">Acciones Realizadas En el mes</div>
                        <div class="stat-change positive">+<?php echo $acciones_realizadas_cambio; ?> hoy</div>
                    </div>
                </section>

                <div class="main-content">
                    <div>

                        <section class="quick-actions">
                            <h2 class="section-title">Acciones Rápidas</h2>
                            <div class="actions-grid">
                                <a href="recibir_documentos.php" class="action-card">
                                    <div class="action-icon icon-pending"><i class="fas fa-clock"></i></div>
                                    <div class="action-title">
                                        Archivos Pendientes
                                        <span class="action-badge"><?php echo $documentos_pendientes_total; ?></span>
                                    </div>
                                    <div class="action-description">
                                        <?php 
                                        echo $documentos_pendientes_total === 1 ? 
                                            'Revisar archivo que requiere aprobación o rechazo' :
                                            'Revisar archivos que requieren aprobación o rechazo';
                                        ?>
                                    </div>
                                </a>

                                <a href="archivos_auditor.php" class="action-card">
                                    <div class="action-icon icon-files"><i class="fas fa-eye"></i></div>
                                    <div class="action-title">Ver Archivos</div>
                                    <div class="action-description">
                                        Consultar todos los documentos del sistema organizados por categoría
                                    </div>
                                </a>

                                <a href="solicitar_documento.php" class="action-card">
                                    <div class="action-icon icon-request"><i class="fa-solid fa-file-arrow-down"></i></div>
                                    <div class="action-title">Solicitar Archivos</div>
                                    <div class="action-description">
                                        Realizar solicitudes de documentos específicos a los documentadores
                                    </div>
                                </a>

                                <a href="archivo_historico.php" class="action-card">
                                    <div class="action-icon icon-archive"><i class="fas fa-history"></i> </div>
                                    <div class="action-title">Archivo Histórico</div>
                                    <div class="action-description">
                                        Acceder al historial completo de documentos archivados del sistema
                                    </div>
                                </a>

                                <a href="pista_auditoria.php" class="action-card">
                                    <div class="action-icon icon-audit"><i class="fas fa-list-check"></i></div>
                                    <div class="action-title">Pista de Auditoría</div>
                                    <div class="action-description">
                                        Ver el registro detallado de todas las acciones realizadas en el sistema
                                    </div>
                                </a>

                                <a href="info_auditor.php" class="action-card">
                                    <div class="action-icon icon-user"><i class="fas fa-info-circle"></i></div>
                                    <div class="action-title">Información del Usuario</div>
                                    <div class="action-description">
                                        Gestionar perfil, configuración y preferencias de la cuenta
                                    </div>
                                </a>
                            </div>
                        </section>
                    </div>

                    <aside>
                        <section class="recent-activity">
                            <h2 class="section-title">Actividad Reciente</h2>

                            <?php foreach ($actividades_recientes as $actividad): ?>
                            <div class="activity-item">
                                <div class="activity-icon <?php echo $actividad['tipo_accion'] . ' ' . obtenerClaseIcono($actividad['tipo_accion']); ?>">
                                    <i class="<?php echo obtenerIconoFontAwesome($actividad['tipo_accion']); ?>"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text"><?php echo htmlspecialchars(generarTextoActividad($actividad)); ?></div>
                                    <div class="activity-time"><?php echo htmlspecialchars($actividad['tiempo']); ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <?php if (empty($actividades_recientes)): ?>
                            <div class="activity-item">
                                <div class="activity-icon pending icon-clock">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">No hay actividad reciente</div>
                                    <div class="activity-time">-</div>
                                </div>
                            </div>
                            <?php endif; ?>

                        </section>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>

</html>