<?php
session_start();

require_once '../../helpers/verificacion_roles.php';
AutorizacionRol('administrador');

$exito = $_SESSION['exito'] ?? null;
unset($_SESSION['exito']);

$corre_exitente = $_SESSION['correo_existente'] ?? null;
unset($_SESSION['correo_existente']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin | Metadocs</title>
    <link rel="icon" href="../../../componentes/img/logopng.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../../componentes/css/admin/panel.css" />
    <link rel="stylesheet" href="../../../componentes/css/cambio_contra.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../../../componentes/js/admin/panel.js"></script>
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
                        <a href="../admin/panel_control.php">
                            <i class="fas fa-chart-line"></i>
                            Panel Control
                        </a>
                    </li>

                    <li>
                        <a href="../admin/pista_auditoria.php">
                            <i class="fas fa-clipboard-check"></i>
                            Actividades usuarios
                        </a>
                    </li>

                    <li class="gestion_usuario">
                        <a href="#" id="gestion-usuarios"><i class="fas fa-users"></i> Gestión Usuarios</a>
                        <ul class="sub_menu gestion-submenu" id="sub_menu">
                            <li><a href="../../vistas/admin/creacion_usuario.php"><i class="fas fa-user-plus"></i> Crear usuario</a></li>
                            <li><a href="../admin/ver_usuarios.php"><i class="fas fa-eye"></i> Ver usuario</a></li>
                        </ul>
                    </li>



                    <li class="gestion-usuarios">
                        <a href="#" id="cerrado-usuarios"><i class="fas fa-user"></i> Admin</a>
                        <ul class="sub_menu usuario-submenu" id="sub_menu">
                            <li><a href="../log/informacion_usuario.php"><i class="fas fa-info-circle"></i> Info usuario</a></li>
                            <li><a href="#" class="activo"><i class="fas fa-key"></i> Cambiar contraseña</a></li>
                        </ul>
                    </li>

                    <li class="solo_mobil">
                        <a href="#" id="solo_mobil"><i class="fas fa-arrow-left"></i> Volver</a>
                    </li>
                </div>


                <li class="cerrar-sesion-separado">
                    <a href="#" id="cerrar_sesion"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
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
                            <input type="password" id="currentPassword" class="form-input" required>
                            <button type="button" class="password-toggle" data-target="currentPassword"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="newPassword" class="form-label">Nueva Contraseña</label>
                        <div style="position: relative;">
                            <input type="password" id="newPassword" class="form-input" required>
                            <button type="button" class="password-toggle" data-target="newPassword"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                        <div style="position: relative;">
                            <input type="password" id="confirmPassword" class="form-input" required>
                            <button type="button" class="password-toggle" data-target="confirmPassword"><i class="fas fa-eye"></i></button>
                        </div>
                        <div class="error-message" id="confirmError">
                            <i class="fas fa-times-circle"></i> <span>Las contraseñas no coinciden</span>
                        </div>
                        <div class="success-message" id="confirmSuccess">
                            <i class="fas fa-check-circle"></i> <span>Las contraseñas coinciden</span>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn" disabled>
                        Cambiar Contraseña
                    </button>
                </form>

                <div class="password-requirements">
                    <h4>Requisitos de la contraseña:</h4>
                    <div class="requirement" data-requirement="length">
                        <i class="far fa-circle icon"></i>
                        <span>Mínimo 8 caracteres</span>
                    </div>
                    <div class="requirement" data-requirement="uppercase">
                        <i class="far fa-circle icon"></i>
                        <span>Al menos una mayúscula</span>
                    </div>
                    <div class="requirement" data-requirement="lowercase">
                        <i class="far fa-circle icon"></i>
                        <span>Al menos una minúscula</span>
                    </div>
                    <div class="requirement" data-requirement="number">
                        <i class="far fa-circle icon"></i>
                        <span>Al menos un número</span>
                    </div>
                </div>
            </div>
        </section>

        <script src="../../../componentes/js/log/coincidir_contraseña.js"></script>
        <script src="../../../componentes/js/log/cambio_contraseña.js"></script>
    </main>
    <?php include '../../vistas/log/modal_cerrar_sesion.php'; ?>
</body>

</html>