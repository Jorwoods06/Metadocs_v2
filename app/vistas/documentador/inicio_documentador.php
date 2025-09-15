<?php 

require_once '../../backend/documentador/inicio_documentador.php'; 
require_once '../../helpers/verificacion_roles.php';

AutorizacionRol('documentador');



?>
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
                <li class="cerrar-sesion-separado"><a href="#" id="cerrar_sesion"><i class="fas fa-sign-out-alt"></i>Cerrar sesion</a></li>
            </ul>
        </nav>
        
        <section id="admin-contenido" class="admin">
            <div class="container">
                <!-- Header -->
                <header class="header">
                    <div class="header-content">
                        <h1 class="header-title">Inicio</h1>
                        <div class="user-info">
                            <div>Bienvenido <?= htmlspecialchars($usuario_nombre) ?></div>
                        </div>
                    </div>
                </header>

                <!-- Statistics -->
                <section class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon pending-requests">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="stat-number"><?= $solicitudes_pendientes_total ?></div>
                        <div class="stat-label">Solicitudes Sin Revisar</div>
                        <div class="stat-change <?= $solicitudes_pendientes_cambio >= 0 ? 'positive' : 'negative' ?>">
                            <?= ($solicitudes_pendientes_cambio >= 0 ? '+' : '') . $solicitudes_pendientes_cambio ?> esta semana
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon uploaded-docs">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="stat-number"><?= $documentos_subidos_total ?></div>
                        <div class="stat-label">Documentos Subidos</div>
                        <div class="stat-change <?= $documentos_subidos_cambio >= 0 ? 'positive' : 'negative' ?>">
                            <?= ($documentos_subidos_cambio >= 0 ? '+' : '') . $documentos_subidos_cambio ?> este mes
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon created-expedients">
                            <i class="fas fa-folder-plus"></i>
                        </div>
                        <div class="stat-number"><?= $expedientes_creados_total ?></div>
                        <div class="stat-label">Expedientes Creados</div>
                        <div class="stat-change <?= $expedientes_creados_cambio >= 0 ? 'positive' : 'negative' ?>">
                            <?= ($expedientes_creados_cambio >= 0 ? '+' : '') . $expedientes_creados_cambio ?> este mes
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon approved-items">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-number"><?= $items_aprobados_total ?></div>
                        <div class="stat-label">Archivos Aprobados</div>
                        <div class="stat-change <?= $items_aprobados_cambio >= 0 ? 'positive' : 'negative' ?>">
                            <?= ($items_aprobados_cambio >= 0 ? '+' : '') . $items_aprobados_cambio ?> este mes
                        </div>
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
                                        <?php if ($solicitudes_nuevas_hoy > 0): ?>
                                            <span class="action-badge"><?= $solicitudes_nuevas_hoy ?></span>
                                        <?php endif; ?>
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
                            
                            <?php if (empty($actividad_reciente)): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">No hay actividad reciente</div>
                                        <div class="activity-time">-</div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($actividad_reciente as $actividad): ?>
                                    <?php
                                    // Generar icono
                                    $icono_map = [
                                        'subió_documento' => 'fas fa-file-upload',
                                        'subió_expediente' => 'fas fa-folder-plus',
                                        'editó_documento' => 'fas fa-edit',
                                        'editó_expediente' => 'fas fa-folder-open',
                                        'creó_documento' => 'fas fa-file-plus',
                                        'creó_expediente' => 'fas fa-folder-plus',
                                        'eliminó_documento' => 'fas fa-trash-alt',
                                        'eliminó_expediente' => 'fas fa-folder-minus'
                                    ];
                                    $clave_icono = $actividad['accion'] . '_' . $actividad['entidad'];
                                    $icono_clase = $icono_map[$clave_icono] ?? 'fas fa-file-alt';

                                    // Generar clases CSS
                                    $clase_map = [
                                        'subió_documento' => 'uploaded icon-uploaded',
                                        'subió_expediente' => 'created icon-created',
                                        'editó_documento' => 'edited icon-edited',
                                        'editó_expediente' => 'edited icon-edited',
                                        'creó_documento' => 'created icon-created',
                                        'creó_expediente' => 'created icon-created'
                                    ];
                                    $clase_css = $clase_map[$clave_icono] ?? 'uploaded icon-uploaded';

                                    // Generar texto
                                    $texto_map = [
                                        'subió_documento' => 'Subiste el documento',
                                        'subió_expediente' => 'Subiste el expediente',
                                        'editó_documento' => 'Editaste el documento',
                                        'editó_expediente' => 'Editaste el expediente',
                                        'creó_documento' => 'Creaste el documento',
                                        'creó_expediente' => 'Creaste el expediente'
                                    ];
                                    $texto_base = $texto_map[$clave_icono] ?? 'Modificaste el elemento';
                                    $texto_completo = $texto_base . ' "' . htmlspecialchars($actividad['nombre_entidad']) . '"';
                                    ?>
                                    <div class="activity-item">
                                        <div class="activity-icon <?= $clase_css ?>">
                                            <i class="<?= $icono_clase ?>"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-text"><?= $texto_completo ?></div>
                                            <div class="activity-time"><?= htmlspecialchars($actividad['tiempo']) ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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