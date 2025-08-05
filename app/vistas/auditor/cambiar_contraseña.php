<?php 

require_once "..\..\backend/administrador/interfaz_usuario.php";
require_once '../../helpers/verificacion_roles.php';

AutorizacionRol('auditor');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor | Metadocs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css">
    <link rel="stylesheet" href="../../../componentes/css/cambio_contra.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
 
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
                    <a href="inicio_auditor.php" >
                        <i class="bi bi-house-door"></i>
                        Inicio
                    </a>
                </li>
                <li class="gestion_usuario">
                    <a href="#" id="gestion-usuarios" >
                        <i class="bi bi-file-earmark-text" ></i>
                        Gestión Archivos
                    </a>
                    <ul class="sub_menu gestion-submenu" id="sub_menu">
                        <li><a href="recibir_documentos.php"><i class="bi bi-envelope-paper"></i>pendientes</a></li>
                        <li><a href="archivos_auditor.php"><i class="bi bi-eye"></i>Archivos</a></li>
                        <li><a href="solicitar_documento.php"><i class="bi bi-file-earmark-plus"></i> Solicitar archivos</a></li>
                        <li><a href=""  class="submenu-activo"> <i class="bi bi-clock-history"></i> Archivo historico</a></li>
                    </ul>
                </li>
                
                <li>
                    <a href="../../vistas/auditor/pista_auditoria.php" >
                        <i class="bi bi-list-check"></i>
                        Pista auditoria
                    </a>
                </li>
                
                <li class="gestion-usuarios">
                    <a href="#" id="cerrado-usuarios" class="activo">
                        <i class="bi bi-person"></i>
                        Auditor
                    </a>
                    <ul class="sub_menu usuario-submenu" id="sub_menu">
                        
                         <li><a href="../../vistas/auditor/info_auditor.php"><i class="bi bi-info-circle"></i> Info auditor</a></li>
                        <li><a href=""><i class="bi bi-key-fill"></i> Cambiar contraseña</a></li>
                    </ul>
                </li>

                <li class="solo_mobil">
                    <a href="#" id="solo_mobil">
                        <i class="bi bi-arrow-left-circle"></i>
                        Volver
                    </a>
                </li>
            </div>

            <li class="cerrar-sesion-separado">
            <a href="#" id="cerrar_sesion"><i class="bi bi-box-arrow-left"></i>Cerrar sesión</a>
        </li>
            </ul>
        </nav>
        
        
       <section id="admin-contenido" class="admin">
    <div class="container">
        <div class="header">
            <h1>Cambiar Contraseña</h1>
            <p>Actualiza tu contraseña para mantener tu cuenta segura</p>
        </div>

        <form id="passwordForm" action="../../backend/login/cambio_contraseña_bd.php" method="post">
            <div class="form-group">
                <label for="currentPassword" class="form-label">Contraseña Actual</label>
                <div style="position: relative;">
                    <input type="password" id="currentPassword" name="currentPassword" class="form-input" required>
                    <button type="button" class="password-toggle" data-target="currentPassword"><i class="bi bi-eye"></i></button>
                </div>
            </div>

            <div class="form-group">
                <label for="newPassword" class="form-label">Nueva Contraseña</label>
                <div style="position: relative;">
                    <input type="password" id="newPassword" class="form-input" required>
                    <button type="button" class="password-toggle" data-target="newPassword"><i class="bi bi-eye"></i></button>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                <div style="position: relative;">
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" required>
                    <button type="button" class="password-toggle " data-target="confirmPassword"><i class="bi bi-eye"></i></button>
                </div>
                <div class="error-message" id="confirmError">
                    <i class="bi bi-x-circle"></i> <span>Las contraseñas no coinciden</span>
                </div>
                <div class="success-message" id="confirmSuccess">
                    <i class="bi bi-check-circle"></i> <span>Las contraseñas coinciden</span>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn" disabled>
                Cambiar Contraseña
            </button>
        </form>

        <div class="password-requirements">
            <h4>Requisitos de la contraseña:</h4>
            <div class="requirement" data-requirement="length">
                <i class="bi bi-circle icon"></i>
                <span>Mínimo 8 caracteres</span>
            </div>
            <div class="requirement" data-requirement="uppercase">
                <i class="bi bi-circle icon"></i>
                <span>Al menos una mayúscula</span>
            </div>
            <div class="requirement" data-requirement="lowercase">
                <i class="bi bi-circle icon"></i>
                <span>Al menos una minúscula</span>
            </div>
            <div class="requirement" data-requirement="number">
                <i class="bi bi-circle icon"></i>
                <span>Al menos un número</span>
            </div>
        </div>
    </div>
    </section>

    </main>
    <script src="../../../componentes/js/log/cambio_contraseña.js"></script>
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>
</html>
